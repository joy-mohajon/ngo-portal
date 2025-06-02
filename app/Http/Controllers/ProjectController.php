<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ngo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // Start with base query
    $query = Project::with(['holder', 'runner', 'focusArea']);

    // Apply filters if they exist
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    if ($request->has('sector') && $request->sector != '') {
        $query->whereHas('focusArea', function($q) use ($request) {
            $q->where('name', $request->sector);
        });
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
                'runner' => $project->runner->name ?? 'Unknown',
                'email' => $project->holder->email ?? '',
                'start_date' => $project->start_date->format('M Y'),
                'end_date' => $project->end_date->format('M Y'),
                'sector' => $project->focus_area,
                'budget' => $project->budget,
                'location' => $project->location,
                'status' => $project->status,
                'focus_area_name' => $project->focusArea->name ?? '-',
            ];
        });

    // Get unique values for filter dropdowns
    $statuses = Project::select('status')->distinct()->pluck('status');
    $focusAreaIds = Project::select('focus_area')->distinct()->pluck('focus_area');
    $sectors = \App\Models\FocusArea::whereIn('id', $focusAreaIds)->pluck('name');
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
        $focusAreas = \App\Models\FocusArea::where('type', 'Project')->orderBy('name')->get();
        return view('projects.create', compact('ngos', 'focusAreas'));
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
            'focus_area' => 'required',
            'holder_id' => 'required|exists:ngos,id',
            'runner_id' => 'required|exists:ngos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,completed,suspended,pending',
            'major_activities' => 'nullable|array',
            'major_activities.*' => 'nullable|string|max:255',
        ]);
        $validated['major_activities'] = $request->has('major_activities') ? array_values(array_filter($request->major_activities, fn($a) => $a !== null && $a !== '')) : [];
        Project::create($validated);
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $user = Auth::user();
        
        // For NGO users, enforce access control
        if ($user && $user->ngo) {
            // Check if user has NGO role using direct database query
            $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->where('roles.name', 'ngo')
                ->exists();
                
            if ($hasNgoRole) {
                // Use the policy to verify permission
                if (!($user->ngo->id === $project->holder_id || $user->ngo->id === $project->runner_id)) {
                    return redirect()->route('projects.runner')
                        ->with('error', 'You do not have permission to view this project. You can only view projects where you are the holder or runner.');
                }
            }
        }
        
        $project->load([
            'holder', 
            'runner', 
            'trainings', 
            'reports',
            'testimonials',
            'focusArea',
        ]);
        
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $user = Auth::user();
        
        // If user is an NGO, check if they are the runner of this project
        if ($user && $user->ngo) {
            // Check if user has NGO role using direct database query
            $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->where('roles.name', 'ngo')
                ->exists();
                
            if ($hasNgoRole) {
                // Check if they are the runner for this project
                if ($project->runner_id != $user->ngo->id) {
                    return redirect()->route('projects.index')
                        ->with('error', 'You do not have permission to edit this project. You can only edit projects where you are the runner.');
                }
            }
        }
        
        // Normalize data types and formats for all fields to ensure consistent comparison in view
        
        // 1. Cast numeric fields to appropriate types
        $project->focus_area = (int)$project->focus_area;
        $project->holder_id = (int)$project->holder_id;
        $project->runner_id = (int)$project->runner_id;
        $project->budget = (float)$project->budget;
        
        // 2. Ensure string fields are properly cast and normalized
        $project->title = (string)$project->title;
        $project->description = (string)$project->description;
        $project->location = (string)$project->location;
        
        // 3. Normalize status to lowercase for case-insensitive comparison
        $project->status = strtolower((string)$project->status);
        
        // 4. Date fields are handled by Laravel's date casting
        // No need to format them here as it's done in the view
        
        // 5. Ensure major_activities is an array
        if (!is_array($project->major_activities)) {
            if (empty($project->major_activities)) {
                $project->major_activities = [];
            } else if (is_string($project->major_activities)) {
                $project->major_activities = explode(',', $project->major_activities);
            } else {
                $project->major_activities = (array)$project->major_activities;
            }
        }
        
        $ngos = Ngo::pluck('name', 'id');
        $focusAreas = \App\Models\FocusArea::where('type', 'Project')->orderBy('name')->get();
        return view('projects.edit', compact('project', 'ngos', 'focusAreas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $user = Auth::user();
        
        // If user is an NGO, check if they are the runner of this project
        if ($user && $user->ngo) {
            // Check if user has NGO role using direct database query
            $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->where('roles.name', 'ngo')
                ->exists();
                
            if ($hasNgoRole) {
                // Check if they are the runner for this project
                if ($project->runner_id != $user->ngo->id) {
                    return redirect()->route('projects.index')
                        ->with('error', 'You do not have permission to update this project. You can only update projects where you are the runner.');
                }
            }
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'focus_area' => 'required',
            'holder_id' => 'required|exists:ngos,id',
            'runner_id' => 'required|exists:ngos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:active,completed,suspended,pending',
            'major_activities' => 'nullable|array',
            'major_activities.*' => 'nullable|string|max:255',
        ]);
        
        // Process and normalize data before saving
        
        // 1. Ensure numeric fields are properly formatted
        $validated['focus_area'] = (int)$validated['focus_area'];
        $validated['holder_id'] = (int)$validated['holder_id'];
        $validated['runner_id'] = (int)$validated['runner_id'];
        
        if (isset($validated['budget'])) {
            $validated['budget'] = (float)$validated['budget'];
        }
        
        // 2. Process major_activities to ensure consistent format
        $validated['major_activities'] = $request->has('major_activities') 
            ? array_values(array_filter($request->major_activities, fn($a) => $a !== null && $a !== '')) 
            : [];
            
        // 3. Date fields are handled by Laravel's date casting
        // No need to format them here
        
        // 4. Ensure status is properly formatted (lowercase for database consistency)
        $validated['status'] = strtolower($validated['status']);
        
        // For NGO users, ensure they can't change the runner to someone else
        if ($user && $user->ngo && $hasNgoRole) {
            $validated['runner_id'] = $user->ngo->id;
        }
        
        $project->update($validated);
        
        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $user = Auth::user();
        
        // If user is an NGO, check if they are the runner of this project
        if ($user && $user->ngo) {
            // Check if user has NGO role using direct database query
            $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->where('roles.name', 'ngo')
                ->exists();
                
            if ($hasNgoRole) {
                // Check if they are the runner for this project
                if ($project->runner_id != $user->ngo->id) {
                    return redirect()->route('projects.index')
                        ->with('error', 'You do not have permission to delete this project. You can only delete projects where you are the runner.');
                }
            }
        }
        
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
        $user = Auth::user();
        
        // For NGO users, enforce access control
        if ($user && $user->ngo) {
            // Check if user has NGO role using direct database query
            $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->where('roles.name', 'ngo')
                ->exists();
                
            if ($hasNgoRole) {
                // Use the policy to verify permission
                if (!($user->ngo->id === $project->holder_id || $user->ngo->id === $project->runner_id)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to view this project. You can only view projects where you are the holder or runner.'
                    ], 403);
                }
            }
        }
        
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

    public function holderProjects(Request $request)
    {
        $user = Auth::user();
        $ngoId = $user && $user->ngo ? $user->ngo->id : null;
        if (!$ngoId) abort(403);
        $request->merge(['holder_id' => $ngoId]);
        return $this->filteredProjectsByRole($request, 'holder_id');
    }

    public function runnerProjects(Request $request)
    {
        $user = Auth::user();
        $ngoId = $user && $user->ngo ? $user->ngo->id : null;
        if (!$ngoId) abort(403);
        $request->merge(['runner_id' => $ngoId]);
        return $this->filteredProjectsByRole($request, 'runner_id');
    }

    protected function filteredProjectsByRole(Request $request, $roleField)
    {
        $query = Project::with(['holder', 'runner', 'focusArea']);
        $query->where($roleField, $request[$roleField]);
        // Apply other filters as in index()
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->has('sector') && $request->sector != '') {
            $query->whereHas('focusArea', function($q) use ($request) {
                $q->where('name', $request->sector);
            });
        }
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        if ($request->has('organization') && $request->organization != '') {
            $query->whereHas('holder', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->organization.'%');
            });
        }
        $projects = $query->latest()->get()->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->title,
                'organization' => $project->holder->name ?? 'Unknown',
                'runner' => $project->runner->name ?? 'Unknown',
                'email' => $project->holder->email ?? '',
                'start_date' => $project->start_date->format('M Y'),
                'end_date' => $project->end_date->format('M Y'),
                'sector' => $project->focus_area,
                'budget' => $project->budget,
                'location' => $project->location,
                'status' => $project->status,
                'focus_area_name' => $project->focusArea->name ?? '-',
            ];
        });
        // Get unique values for filter dropdowns (reuse logic from index)
        $statuses = Project::select('status')->distinct()->pluck('status');
        $focusAreaIds = Project::select('focus_area')->distinct()->pluck('focus_area');
        $sectors = \App\Models\FocusArea::whereIn('id', $focusAreaIds)->pluck('name');
        $locations = Project::select('location')->distinct()->pluck('location');
        $organizations = \App\Models\Ngo::select('name as organization')->distinct()->pluck('organization');
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
}