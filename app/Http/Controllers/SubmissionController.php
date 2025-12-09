<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = Submission::with('assignment')->get();

        return view('main.submissions.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignments = Assignment::all();

        return view('main.submissions.create', compact('assignments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pdf_files' => 'required|array|min:1',
            'pdf_files.*' => 'mimes:pdf',
            'assignment_id' => 'required|exists:assignments,id',
            'student_name' => 'nullable|string',
        ]);

        $name = $request->input('student_name', 'Anonymous');
        $parser = new Parser;

        foreach ($request->file('pdf_files') as $file) {
            $path = $file->store('submissions');
            $pdf = $parser->parseFile(storage_path('app/'.$path));
            $text = $pdf->getText();

            Submission::create([
                'assignment_id' => $request->assignment_id,
                'student_name' => $name,
                'file_path' => $path,
                'extracted_text' => $text,
            ]);
        }

        return redirect()->route('submissions.index')->with('success', 'Submission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        $submission->load('result');
        return view('main.submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        return view('main.submissions.edit', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'student_name' => 'required|string',
        ]);

        $submission->update($validated);

        return redirect()->route('submissions.index')->with('success', 'Submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        // Optionally delete the file
        if (Storage::exists($submission->file_path)) {
            Storage::delete($submission->file_path);
        }

        $submission->delete();

        return redirect()->route('submissions.index')->with('success', 'Submission deleted successfully.');
    }

    /**
     * Download the submission file.
     */
    public function download(Submission $submission)
    {
        $path = storage_path('app/' . $submission->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, basename($submission->file_path));
    }
}
