<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Training;
use App\Models\Ngo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectTrainingController extends Controller
{
    /**
     * Display a listing of trainings for a specific project.
     */
    public function index(Project $project)
    {
        $trainings = $project->trainings()
            ->with('organizer')
            ->latest()
            ->paginate(10);
            
        return view('projects.trainings.index', compact('project', 'trainings'));
    }

    /**
     * Show the form for creating a new training for the project.
     */
    public function create(Project $project)
    {
        // If you need to select from multiple organizers:
        $organizers = Ngo::pluck('name', 'id');
        
        return view('projects.trainings.create', compact('project', 'organizers'));
    }

    /**
     * Store a newly created training for the project.
     */
    public function store(Request $request, Project $project)
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
            'organizer_id' => 'required|exists:organizers,id',
        ]);

        // Automatically associate with the project
        $validated['project_id'] = $project->id;
        
        Training::create($validated);
        
        return redirect()->route('projects.trainings.index', $project)
            ->with('success', 'Training created successfully.');
    }

    /**
     * Display the specified training for the project.
     */
    public function show(Training $training)
    {
        // Load the related project
        $training->load('project', 'organizer');
    
       // Regular return (after debugging)
        return view('projects.trainings.show', [
            'training' => $training,
            'project' => $training->project
        ]);
    }

    /**
     * Show the form for editing the specified training.
     */
    public function edit(Training $training)
    {
        // Get project from the training relationship
        $project = $training->project;
        
        // Verify training belongs to project (optional but recommended)
        if (!$project) {
            abort(404);
        }
    
        $organizers = Ngo::pluck('name', 'id');
        return view('projects.trainings.edit', compact('project', 'training', 'organizers'));
    }

    /**
     * Update the specified training in storage.
     */
    public function update(Request $request, Project $project, Training $training)
    {
        if ($training->project_id !== $project->id) {
            abort(404);
        }
        
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
            'organizer_id' => 'required|exists:organizers,id',
        ]);
        
        $training->update($validated);
        
        return redirect()->route('projects.trainings.show', [$project, $training])
            ->with('success', 'Training updated successfully.');
    }

    /**
     * Remove the specified training from storage.
     */
    public function destroy(Project $project, Training $training)
    {
        if ($training->project_id !== $project->id) {
            abort(404);
        }
        
        $training->delete();
        
        return redirect()->route('projects.trainings.index', $project)
            ->with('success', 'Training deleted successfully.');
    }
}