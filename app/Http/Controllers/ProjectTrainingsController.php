<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectTrainingsController extends Controller
{
    /**
     * Display trainings for a specific project.
     */
    public function index(Project $project)
    {
        try {
            $project->load(['holder', 'runner']);
            
            // Check if trainings relationship works or fallback to direct query
            $trainings = Training::where('project_id', $project->id)
                        ->with('organizer')
                        ->latest()
                        ->paginate(10);
            
            // Log for debugging
            Log::info("Project ID: {$project->id}");
            Log::info("Trainings count: " . $trainings->count());
            
            return view('projects.trainings', compact('project', 'trainings'));
        } catch (\Exception $e) {
            Log::error('Error in ProjectTrainingsController: ' . $e->getMessage());
            return redirect()->route('projects.index')
                ->with('error', 'There was an error retrieving trainings for this project: ' . $e->getMessage());
        }
    }
} 