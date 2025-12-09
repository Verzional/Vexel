<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Result;
use App\Services\GradingService;
use Illuminate\Http\Request;

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
                'submission_id'  => $submission->id,
                'score'          => $aiResult['grade'],
                'reasoning'      => $aiResult['reasoning'],
                'notable_points' => $aiResult['notable_points'], 
                'is_verified'    => false, 
            ]);

            return back()->with('success', 'AI Grading complete! Please review and verify.');

        } catch (\Exception $e) {
            \Log::error("Grading failed: " . $e->getMessage());
            return back()->with('error', 'AI service is temporarily unavailable.');
        }
    }
}