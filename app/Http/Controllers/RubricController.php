<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Rubric;
use Illuminate\Http\Request;

class RubricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rubrics = Rubric::with('assignment')
            ->when($request->search, function ($query, $search) {
                $query->where('subject_name', 'like', "%{$search}%")
                    ->orWhere('criteria', 'like', "%{$search}%")
                    ->orWhereHas('assignment', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        return view('main.rubrics.index', compact('rubrics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignments = Assignment::doesntHave('rubric')->get();

        return view('main.rubrics.create', compact('assignments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:assignments,id|unique:rubrics,assignment_id',
            'subject_name' => 'required|string',
            'criteria' => 'required|array',
            'criteria.*.indicator' => 'required|string',
            'criteria.*.criteria' => 'required|string',
            'criteria.*.weight' => 'required|numeric|min:0|max:100',
            'criteria.*.levels' => 'required|array|min:1',
            'criteria.*.levels.*.min' => 'required|numeric|min:0|max:100',
            'criteria.*.levels.*.max' => 'required|numeric|min:0|max:100',
            'criteria.*.levels.*.grade' => 'required|string',
            'criteria.*.levels.*.description' => 'required|string',
        ]);

        Rubric::create($validated);

        return redirect()->route('rubrics.index')->with('success', 'Rubric created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rubric $rubric)
    {
        $rubric->load('assignment');

        return view('main.rubrics.show', compact('rubric'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rubric $rubric)
    {
        $rubric->load('assignment');
        $assignments = Assignment::doesntHave('rubric')
            ->orWhere('id', $rubric->assignment_id)
            ->get();

        return view('main.rubrics.edit', compact('rubric', 'assignments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rubric $rubric)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:assignments,id|unique:rubrics,assignment_id,' . $rubric->id,
            'subject_name' => 'required|string',
            'criteria' => 'required|array',
            'criteria.*.indicator' => 'required|string',
            'criteria.*.criteria' => 'required|string',
            'criteria.*.weight' => 'required|numeric|min:0|max:100',
            'criteria.*.levels' => 'required|array|min:1',
            'criteria.*.levels.*.min' => 'required|numeric|min:0|max:100',
            'criteria.*.levels.*.max' => 'required|numeric|min:0|max:100',
            'criteria.*.levels.*.grade' => 'required|string',
            'criteria.*.levels.*.description' => 'required|string',
        ]);

        $rubric->update($validated);

        return redirect()->route('rubrics.index')->with('success', 'Rubric updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rubric $rubric)
    {
        $rubric->delete();

        return redirect()->route('rubrics.index')->with('success', 'Rubric deleted successfully.');
    }
}
