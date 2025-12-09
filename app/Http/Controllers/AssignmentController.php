<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Rubric;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = Assignment::with('rubric')->get();
        return view('main.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rubrics = Rubric::all();
        return view('main.assignments.create', compact('rubrics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // app/Http/Controllers/AssignmentController.php
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'rubric_id' => 'required|exists:rubrics,id',
        ]);

        Assignment::create($validated);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        return view('main.assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        $rubrics = Rubric::all();
        return view('main.assignments.edit', compact('assignment', 'rubrics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'rubric_id' => 'required|exists:rubrics,id',
        ]);

        $assignment->update($validated);

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}
