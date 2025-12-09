<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $assignmentId)
    {
        $request->validate(['pdf_file' => 'required|mimes:pdf']);

        $path = $request->file('pdf_file')->store('submissions');

        $name = $request->input('student_name', 'Anonymous');

        $parser = new Parser;
        $pdf = $parser->parseFile(storage_path('app/'.$path));
        $text = $pdf->getText();

        Submission::create([
            'assignment_id' => $assignmentId,
            'student_name' => $name,
            'file_path' => $path,
            'extracted_text' => $text, 
        ]);

        return back()->with('success', 'Work submitted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
