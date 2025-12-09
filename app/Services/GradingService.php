<?php

namespace App\Services;

use App\Models\Result;
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
        $rubricText = $submission->assignment->rubric->content;
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

        $prompt = $this->buildPrompt($rubricText, $studentText, $historyExamples);

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

    public function buildPrompt(string $rubric, string $currentStudentWork, $examples)
    {
        $prompt = "You are an expert academic grader. Your task is to grade a student submission based strictly on the provided Rubric.\n\n";

        $prompt .= "### GRADING RUBRIC (RPS):\n";
        $prompt .= $rubric."\n\n";

        if ($examples->isNotEmpty()) {
            $prompt .= "### REFERENCE EXAMPLES (How I want you to grade):\n";
            $prompt .= "Use these examples to understand the strictness and reasoning style required.\n\n";

            foreach ($examples as $index => $result) {
                $num = $index + 1;
                $exampleText = Str::limit($result->submission->extracted_text, 600);

                $prompt .= "--- EXAMPLE #{$num} ---\n";
                $prompt .= "Student Input Snippet: \"{$exampleText}...\"\n";
                $prompt .= "Assigned Grade: {$result->score}\n";
                $prompt .= "Examiner Reasoning: {$result->reasoning}\n\n";
            }
        }

        $prompt .= "### CURRENT STUDENT SUBMISSION (Grade this):\n";
        $prompt .= $currentStudentText."\n\n";

        $prompt .= "### OUTPUT FORMAT:\n";
        $prompt .= "Return strict JSON. Do not use Markdown code blocks. keys: 'grade' (int), 'reasoning' (string), 'notable_points' (array of strings).";

        return $prompt;
    }
}