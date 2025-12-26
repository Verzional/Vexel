<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $assignments = Assignment::with(['course', 'rubric'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('rubric', function ($q) use ($search) {
                        $q->where('subject_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        return view('main.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();

        return view('main.assignments.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        Assignment::create($validated);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        $assignment->load(['course', 'rubric']);

        return view('main.assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        $courses = Course::all();

        return view('main.assignments.edit', compact('assignment', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'required|string',
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
