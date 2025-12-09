<?php

namespace App\Services;

use App\Models\Result;
use App\Models\Rubric;
use App\Models\Submission;
use Illuminate\Support\Facades\Http;

class GradingService
{
    protected $apiKey;

    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function gradeSubmission(Submission $submission)
    {
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

        return json_decode($generatedText, true);
    }

    private function buildPrompt(Rubric $rubric, string $studentText, string $assignmentDescription, $examples)
    {
        $prompt = "You are an expert academic grader for the subject: {$rubric->subject_name}.\n";
        $prompt .= "Your task is to grade a student's work based on the weighted criteria below.\n\n";

        $prompt .= "### ASSIGNMENT INSTRUCTIONS (Topic):\n";
        $prompt .= $assignmentDescription."\n";
        $prompt .= "IMPORTANT: If the student's submission is not relevant to these instructions, penalize the grade significantly, even if the rubric criteria are met.\n\n";

        $prompt .= "### GRADING CRITERIA (The Rules):\n";
        foreach ($rubric->criteria as $criterion) {
            $name = $criterion['name'];
            $weight = $criterion['weight'];
            $desc = $criterion['description'] ?? '';

            $prompt .= "- **{$name}** (Weight: {$weight}%)\n";
            if ($desc) {
                $prompt .= "  Context: $desc\n";
            }
        }
        $prompt .= "\n";

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
            { "criterion": "Clarity", "score_out_of_100": 80, "weighted_score": 24, "reason": "..." },
            { "criterion": "Understanding", "score_out_of_100": 90, "weighted_score": 18, "reason": "..." }
        ],
            "final_grade": 42,
            "reasoning": "Overall reasoning for the grade...",
            'notable_points': "..."
            "overall_feedback": "..."
        }
        Ensure 'final_grade' is the sum of all 'weighted_score' values.
        EOT;

        return $prompt;
    }
}
