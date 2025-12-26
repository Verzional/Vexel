<?php

namespace App\Services;

use App\Models\Result;
use App\Models\Rubric;
use App\Models\Submission;
use Illuminate\Support\Facades\Http;

class GradingService
{
    protected $apiKey;

    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function gradeSubmission(Submission $submission)
    {
        ini_set('max_execution_time', 300);

        $rubric = $submission->assignment->rubric;
        $assignmentDescription = $submission->assignment->description;
        $studentText = $submission->extracted_text;

        $historyExamples = Result::query()
            ->where('is_verified', true)
            ->whereHas('submission', function ($query) use ($submission) {
                $query->where('assignment_id', $submission->assignment_id);
                $query->where('id', '!=', $submission->id);
            })
            ->with('submission')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $prompt = $this->buildPrompt($rubric, $studentText, $assignmentDescription, $historyExamples);

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withOptions(['verify' => false, 'timeout' => 120]) 
            ->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                ],
            ]);

        if ($response->failed()) {
            throw new \Exception('Gemini API Error: '.$response->body());
        }

        $responseData = $response->json();
        $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

        $decoded = json_decode($generatedText, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON response from AI: '.json_last_error_msg());
        }

        return $decoded;
    }

    private function buildPrompt(Rubric $rubric, string $studentText, string $assignmentDescription, $examples)
    {
        $prompt = "You are an expert academic grader for the subject: {$rubric->subject_name}.\n";
        $prompt .= "Your task is to grade a student's work based on the weighted criteria and performance level descriptors below.\n\n";

        $prompt .= "### ASSIGNMENT INSTRUCTIONS (Topic):\n";
        $prompt .= $assignmentDescription."\n";
        $prompt .= "IMPORTANT: If the student's submission is not relevant to these instructions, penalize the grade significantly, even if the rubric criteria are met.\n\n";

        $prompt .= "### GRADING CRITERIA WITH PERFORMANCE LEVELS:\n";
        $prompt .= "Each criterion has a weight, an indicator, and performance levels that describe the expected quality at each score band.\n\n";
        
        foreach ($rubric->criteria as $criterion) {
            $indicator = $criterion['indicator'] ?? $criterion['name'] ?? 'Unknown';
            $criteriaDesc = $criterion['criteria'] ?? $criterion['description'] ?? '';
            $weight = $criterion['weight'];
            $levels = $criterion['levels'] ?? [];

            $prompt .= "**{$indicator}** (Weight: {$weight}%)\n";
            $prompt .= "What to assess: {$criteriaDesc}\n";
            
            if (!empty($levels)) {
                $prompt .= "Scoring Guide:\n";
                // Sort levels by min score descending (highest first)
                usort($levels, fn($a, $b) => ($b['min'] ?? 0) <=> ($a['min'] ?? 0));
                foreach ($levels as $level) {
                    $min = $level['min'] ?? 0;
                    $max = $level['max'] ?? 100;
                    $grade = $level['grade'] ?? '';
                    $desc = $level['description'] ?? '';
                    $prompt .= "  • {$min}-{$max} ({$grade}): {$desc}\n";
                }
            }
            $prompt .= "\n";
        }

        if ($examples->isNotEmpty()) {
            $prompt .= "### REFERENCE EXAMPLES (Previous Grading Style):\n";
            foreach ($examples as $i => $ex) {
                $prompt .= 'Example #'.($i + 1).': Given score '.$ex->score."\n";
                $prompt .= 'Reasoning: '.$ex->reasoning."\n---\n";
            }
        }

        $prompt .= "### STUDENT SUBMISSION:\n";
        $prompt .= $studentText."\n\n";

        $prompt .= <<<'EOT'
        ### OUTPUT FORMAT:
        Return strict JSON with this structure:
        {
            "breakdown": [
                { 
                    "criterion": "KU1.2 The suitability of methods and data", 
                    "score": 75, 
                    "max_score": 100,
                    "grade": "B",
                    "weighted_score": 37.5
                }
            ],
            "final_grade": 75,
            "reasoning": "Overall reasoning for the grade...",
            "notable_points": ["Point 1", "Point 2", "Point 3"],
            "overall_feedback": "..."
        }
        
        IMPORTANT RULES:
        1. 'score' should be a value between 0-100 based on the performance level descriptors.
        2. 'grade' should match the grade band the score falls into.
        3. 'weighted_score' = (score / 100) * weight of that criterion.
        4. 'final_grade' must be the sum of all 'weighted_score' values (out of 100).
        5. Use the Performance Level descriptors to justify the score and grade given.
        6. Match the criterion name exactly as provided in the indicator.
        EOT;

        return $prompt;
    }
}
