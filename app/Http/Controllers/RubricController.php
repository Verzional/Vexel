<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use Illuminate\Http\Request;

class RubricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rubrics = Rubric::all();
        return view('main.rubrics.index', compact('rubrics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('main.rubrics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'subject_name' => 'required|string',
            'criteria' => 'required|array',
            'criteria.*.name' => 'required|string',
            'criteria.*.weight' => 'required|numeric',
        ]);

        Rubric::create($validated);

        return redirect()->route('rubrics.index')->with('success', 'Rubric created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rubric $rubric)
    {
        return view('main.rubrics.show', compact('rubric'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rubric $rubric)
    {
        return view('main.rubrics.edit', compact('rubric'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rubric $rubric)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string',
            'criteria' => 'required|array',
            'criteria.*.name' => 'required|string',
            'criteria.*.weight' => 'required|numeric',
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
