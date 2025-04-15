<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainings = Training::with('project', 'organizer')->latest()->paginate(10);
        return view('trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::pluck('title', 'id');
        return view('trainings.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:1',
            'registration_deadline' => 'required|date|before:start_date',
            'category' => 'required|string|max:100',
            'status' => 'required|string|in:upcoming,ongoing,completed,cancelled',
            'project_id' => 'required|exists:projects,id',
        ]);

        $validated['organizer_id'] = Auth::id();
        
        Training::create($validated);
        
        return redirect()->route('trainings.index')->with('success', 'Training created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Training $training)
    {
        $training->load('project', 'organizer');
        return view('trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Training $training)
    {
        $projects = Project::pluck('title', 'id');
        return view('trainings.edit', compact('training', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Training $training)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:1',
            'registration_deadline' => 'required|date|before:start_date',
            'category' => 'required|string|max:100',
            'status' => 'required|string|in:upcoming,ongoing,completed,cancelled',
            'project_id' => 'required|exists:projects,id',
        ]);
        
        $training->update($validated);
        
        return redirect()->route('trainings.index')->with('success', 'Training updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->route('trainings.index')->with('success', 'Training deleted successfully.');
    }
}