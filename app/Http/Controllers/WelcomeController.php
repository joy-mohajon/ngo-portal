<?php

namespace App\Http\Controllers;

use App\Models\FocusArea;
use App\Models\Ngo;
use App\Models\Project;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page
     */
    public function index(Request $request)
    {
        // Get project type focus areas for filtering gallery
        $projectFocusAreas = FocusArea::where('type', 'project')->orderBy('name')->get();
        
        // Get NGO type focus areas for filtering NGOs
        $ngoFocusAreas = FocusArea::where('type', 'ngo')->orderBy('name')->get();
        
        // Get selected focus area from request
        $selectedNgoFocusArea = $request->get('ngo_focus_area');
        
        // Build query for gallery images
        $query = ProjectGallery::with(['project' => function($query) {
                $query->with('focusArea');
            }, 'project.runner'])
            ->whereHas('project', function($query) use ($request) {
                // Apply focus area filter if provided
                if ($request->has('focus_area') && $request->focus_area) {
                    $query->where('focus_area', $request->focus_area);
                }
            })
            ->orderBy('created_at', 'desc')
            ->limit(12); // Limit to 12 latest images
        
        // Get gallery images
        $galleryImages = $query->get();
        
        // Transform the collection to add the needed attributes
        $galleryImages->transform(function($image) {
            $image->project_title = $image->project->title ?? 'Unknown Project';
            $image->ngo_name = $image->project->runner->name ?? 'Unknown NGO';
            return $image;
        });
        
        // Get NGOs based on selected focus area
        $ngosQuery = Ngo::with('focusAreas')
            ->where('status', 'approved')
            ->orderBy('name');
            
        // Apply NGO focus area filter if provided
        if ($selectedNgoFocusArea) {
            $ngosQuery->whereHas('focusAreas', function($query) use ($selectedNgoFocusArea) {
                $query->where('focus_areas.id', $selectedNgoFocusArea);
            });
        }
        
        $ngos = $ngosQuery->get();
        
        return view('welcome', compact('galleryImages', 'projectFocusAreas', 'ngoFocusAreas', 'ngos', 'selectedNgoFocusArea'));
    }
    
    /**
     * Get gallery images for AJAX requests
     */
    public function getGalleryImages(Request $request)
    {
        // Get the page number and items per page
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 12);
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Query to get images with focus area filter
        $query = ProjectGallery::with(['project' => function($query) {
                $query->with('focusArea');
            }, 'project.runner'])
            ->whereHas('project', function($query) use ($request) {
                // Apply focus area filter if provided
                if ($request->has('focus_area') && $request->focus_area) {
                    $query->where('focus_area', $request->focus_area);
                }
            })
            ->orderBy('created_at', 'desc');
        
        // Apply pagination
        $galleryImages = $query->skip($offset)->take($perPage)->get();
        
        // Transform the collection to include only needed data
        $formattedImages = $galleryImages->map(function($image) {
            return [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'project_id' => $image->project_id,
                'project_title' => $image->project->title ?? 'Unknown Project',
                'ngo_name' => $image->project->runner->name ?? 'Unknown NGO',
                'focus_area_name' => $image->project->focusArea->name ?? null
            ];
        });
        
        return response()->json($formattedImages);
    }
    
    /**
     * Get NGOs filtered by focus area for AJAX requests
     */
    public function getNgosByFocusArea(Request $request)
    {
        // Get NGOs filtered by focus area
        $ngos = Ngo::whereHas('user', function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'ngo');
                });
            })
            ->where('status', 'approved')
            ->withCount('focusAreas')
            ->with('focusAreas')
            ->orderBy('name')
            ->get();
        
        // Filter by focus area if provided
        $focusAreaId = $request->input('focus_area');
        if ($focusAreaId) {
            $ngos = $ngos->filter(function($ngo) use ($focusAreaId) {
                return $ngo->focusAreas->contains('id', $focusAreaId);
            })->values();
        }
        
        // Transform the collection to include only needed data
        $formattedNgos = $ngos->map(function($ngo) {
            return [
                'id' => $ngo->id,
                'name' => $ngo->name,
                'logo' => $ngo->logo ? asset('storage/' . $ngo->logo) : null,
                'description' => $ngo->description ?? 'Working on development and social welfare projects',
                'focus_areas' => $ngo->focusAreas->take(3)->map(function($area) {
                    return [
                        'id' => $area->id,
                        'name' => $area->name
                    ];
                }),
                'focus_areas_count' => $ngo->focusAreas->count(),
                'profile_url' => route('ngos.show', $ngo)
            ];
        });
        
        return response()->json($formattedNgos);
    }

    /**
     * Display project details for public access without authentication
     */
    public function projectDetails(Project $project)
    {
        // Load only the necessary relationships for a public view
        $project->load([
            'holder', 
            'runner', 
            'focusArea',
            'galleries' // Load gallery images
        ]);
        
        return view('projects.public.details', compact('project'));
    }
    
    /**
     * Display all projects for public access with pagination
     */
    public function projectsIndex(Request $request)
    {
        // Get project type focus areas for filtering
        $focusAreas = FocusArea::where('type', 'project')->orderBy('name')->get();
        
        // Build query for projects
        $query = Project::with(['runner', 'focusArea', 'galleries' => function($query) {
            $query->limit(1); // Get just one gallery image per project for the thumbnail
        }])
        ->orderBy('created_at', 'desc');
        
        // Apply focus area filter if requested
        if ($request->has('focus_area') && $request->focus_area) {
            $query->where('focus_area', $request->focus_area);
        }
        
        // Apply status filter if requested (default to all statuses for public view)
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Paginate with 45 projects per page
        $projects = $query->paginate(45);
        
        return view('projects.public.index', compact('projects', 'focusAreas'));
    }
    
    /**
     * Display all gallery images for public access with pagination
     */
    public function galleryIndex(Request $request)
    {
        // Get project type focus areas for filtering gallery
        $focusAreas = FocusArea::where('type', 'project')->orderBy('name')->get();
        
        // Get all approved NGOs for the filter dropdown
        $ngos = Ngo::where('status', 'approved')->orderBy('name')->get();
        
        // Get total projects count
        $totalProjects = Project::count();
        
        // Build query for gallery images
        $query = ProjectGallery::with(['project' => function($query) {
                $query->with('focusArea');
            }, 'project.runner'])
            ->whereHas('project', function($query) use ($request) {
                // Apply focus area filter if provided
                if ($request->has('focus_area') && $request->focus_area) {
                    $query->where('focus_area', $request->focus_area);
                }
                
                // Apply NGO filter if provided
                if ($request->has('ngo') && $request->ngo) {
                    $query->where('runner_id', $request->ngo);
                }
            })
            ->orderBy('created_at', 'desc');
        
        // Paginate with 45 images per page
        $galleryImages = $query->paginate(45);
        
        // Transform the collection to add the needed attributes
        $galleryImages->getCollection()->transform(function($image) {
            $image->project_title = $image->project->title ?? 'Unknown Project';
            $image->ngo_name = $image->project->runner->name ?? 'Unknown NGO';
            return $image;
        });
        
        return view('gallery.public.index', compact('galleryImages', 'focusAreas', 'ngos', 'totalProjects'));
    }
} 