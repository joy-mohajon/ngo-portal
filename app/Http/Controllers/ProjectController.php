<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ngo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // Start with base query
    $query = Project::with(['holder', 'runner']);

    // Apply filters if they exist
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    if ($request->has('sector') && $request->sector != '') {
        $query->where('focus_area', 'like', '%'.$request->sector.'%');
    }

    if ($request->has('location') && $request->location != '') {
        $query->where('location', 'like', '%'.$request->location.'%');
    }

    if ($request->has('organization') && $request->organization != '') {
        $query->whereHas('holder', function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->organization.'%');
        });
    }

    // Get filtered projects
    $projects = $query->latest()
        ->get()
        ->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->title,
                'organization' => $project->holder->name ?? 'Unknown',
                'email' => $project->holder->email ?? '',
                'start_date' => $project->start_date->format('Y-m-d'),
                'sector' => $project->focus_area,
                'location' => $project->location,
                'status' => $project->status,
            ];
        });

    // Get unique values for filter dropdowns
    $statuses = Project::select('status')->distinct()->pluck('status');
    $sectors = Project::select('focus_area as sector')->distinct()->pluck('sector');
    $locations = Project::select('location')->distinct()->pluck('location');
    $organizations = Ngo::select('name as organization')->distinct()->pluck('organization');

    // Group projects by first letter of their name
    $grouped = [];
    foreach ($projects as $project) {
        $firstLetter = strtoupper(substr($project['name'], 0, 1));
        if (!isset($grouped[$firstLetter])) {
            $grouped[$firstLetter] = [];
        }
        $grouped[$firstLetter][] = $project;
    }

    ksort($grouped);
    $activeLetters = array_keys($grouped);
    $letters = range('A', 'Z');

    return view('projects.index', compact(
        'grouped', 
        'activeLetters', 
        'letters',
        'statuses',
        'sectors',
        'locations',
        'organizations'
    ));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ngos = Ngo::pluck('name', 'id');
        return view('projects.create', compact('ngos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'focus_area' => 'nullable|string|max:255',
            'holder_id' => 'required|exists:ngos,id',
            'runner_id' => 'required|exists:ngos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,completed,suspended,pending',
        ]);
        
        Project::create($validated);
        
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['holder', 'runner', 'trainings', 'reports']);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $ngos = Ngo::pluck('name', 'id');
        return view('projects.edit', compact('project', 'ngos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'focus_area' => 'nullable|string|max:255',
            'holder_id' => 'required|exists:ngos,id',
            'runner_id' => 'required|exists:ngos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,completed,suspended,pending',
        ]);
        
        $project->update($validated);
        
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * API Methods
     */

    /**
     * Get all projects
     */
    public function apiIndex()
    {
        $projects = Project::with(['holder', 'runner'])->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    /**
     * Get a specific project
     */
    public function apiShow(Project $project)
    {
        $project->load(['holder', 'runner', 'trainings', 'reports']);
        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    }

    /**
     * Create a new project
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'focus_area' => 'nullable|string|max:255',
            'holder_id' => 'required|exists:ngos,id',
            'runner_id' => 'required|exists:ngos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,completed,suspended,pending',
        ]);
        
        $project = Project::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
            'data' => $project
        ], 201);
    }

    /**
     * Update an existing project
     */
    public function apiUpdate(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'location' => 'sometimes|nullable|string|max:255',
            'budget' => 'sometimes|nullable|numeric|min:0',
            'focus_area' => 'sometimes|nullable|string|max:255',
            'holder_id' => 'sometimes|required|exists:ngos,id',
            'runner_id' => 'sometimes|required|exists:ngos,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'status' => 'sometimes|required|string|in:active,completed,suspended,pending',
        ]);
        
        $project->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => $project
        ]);
    }

    /**
     * Delete a project
     */
    public function apiDestroy(Project $project)
    {
        $project->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }

    /**
     * Get trainings for a specific project
     */
    public function trainings(Project $project)
    {
        $trainings = $project->trainings()
            ->with('organizer')
            ->latest()
            ->paginate(10);
            
        return response()->json([
            'success' => true,
            'project' => $project->only(['id', 'title']),
            'data' => $trainings
        ]);
    }
}