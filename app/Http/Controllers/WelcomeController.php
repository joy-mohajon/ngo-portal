<?php

namespace App\Http\Controllers;

use App\Models\FocusArea;
use App\Models\Ngo;
use App\Models\Project;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page
     */
    public function index(Request $request)
    {
        // Get all focus areas for filtering
        $focusAreas = FocusArea::orderBy('name')->get();
        
        // Get featured NGOs (top 3 by project count)
        $featuredNgos = Ngo::whereHas('user', function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'ngo');
                });
            })
            ->where('status', 'active')
            ->withCount('focusAreas')
            ->orderBy('focus_areas_count', 'desc')
            ->take(3)
            ->get();
        
        // Build gallery query
        $galleryQuery = ProjectGallery::query()
            ->join('projects', 'project_galleries.project_id', '=', 'projects.id')
            ->where('projects.status', 'active')
            ->select('project_galleries.*', 'projects.title as project_title', 'projects.focus_area');
            
        // Apply focus area filter if provided
        if ($request->has('focus_area') && $request->focus_area) {
            $galleryQuery->where('projects.focus_area', $request->focus_area);
        }
        
        // Get gallery images
        $galleryImages = $galleryQuery->orderBy('project_galleries.created_at', 'desc')
            ->take(12)
            ->get();
        
        // Eager load focus areas for the gallery images
        $galleryImages->load('project.focusArea');
        
        return view('welcome', compact('focusAreas', 'featuredNgos', 'galleryImages'));
    }
} 