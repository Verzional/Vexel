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

        return redirect()->route('main.rubrics.index')->with('success', 'Rubric created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(rubric $rubric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rubric $rubric)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rubric $rubric)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rubric $rubric)
    {
        //
    }
}
