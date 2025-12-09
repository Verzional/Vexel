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
            return back()->with('error', 'Please wait for the PDF to be processed into text.');
        }

        try {
            $aiResult = $this->grader->gradeSubmission($submission);

            Result::create([
                'submission_id' => $submission->id,
                'grade' => $aiResult['final_grade'],
                'reasoning' => $aiResult['reasoning'],
                'notable_points' => $aiResult['notable_points'] ?? '',
                'feedback' => $aiResult['overall_feedback'] ?? '',
                'is_verified' => false,
            ]);

            return back()->with('success', 'AI Grading complete! Please review and verify.');

        } catch (\Exception $e) {
            \Log::error('Grading failed: '.$e->getMessage());

            return back()->with('error', 'AI service is temporarily unavailable.');
        }
    }
}
