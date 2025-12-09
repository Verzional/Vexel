<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Submission;
use App\Services\GradingService;

class GradingController extends Controller
{
    protected $grader;

    public function __construct(GradingService $grader)
    {
        $this->grader = $grader;
    }

    public function grade(Submission $submission)
    {
        if (empty($submission->extracted_text)) {
            $message = 'Please wait for the PDF to be processed into text.';
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }

        try {
            $aiResult = $this->grader->gradeSubmission($submission);

            if (!isset($aiResult['final_grade']) || !isset($aiResult['reasoning'])) {
                throw new \Exception('Incomplete AI response: missing required fields.');
            }

            $notablePoints = $aiResult['notable_points'] ?? [];
            if (is_array($notablePoints)) {
                $notablePoints = implode("\n", $notablePoints);
            }

            $breakdown = $aiResult['breakdown'] ?? [];

            Result::create([
                'submission_id' => $submission->id,
                'grade' => $aiResult['final_grade'],
                'breakdown' => $breakdown,
                'reasoning' => $aiResult['reasoning'],
                'notable_points' => $notablePoints,
                'feedback' => $aiResult['overall_feedback'] ?? '',
                'is_verified' => false,
            ]);

            $message = 'AI Grading complete! Please review and verify.';
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Grading failed: '.$e->getMessage());

            $message = 'AI service is temporarily unavailable.';
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }
    }
}
