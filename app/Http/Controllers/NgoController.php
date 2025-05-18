<?php

namespace App\Http\Controllers;

use App\Models\FocusArea;
use App\Models\Ngo;
use App\Models\Project;
use Illuminate\Http\Request;

class NgoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all approved NGOs with their focus areas
        $ngos = Ngo::with('focusAreas')
                    ->where('status', 'approved')
                    ->get();
        
        // Group by first letter of name (A-Z)
        $groupedByAlphabet = $ngos->groupBy(function($ngo) {
            return strtoupper(substr($ngo->name, 0, 1));
        })->sortKeys();
        
        // Get all focus areas with NGO counts
        $focusAreas = FocusArea::withCount('ngos')
                        ->having('ngos_count', '>', 0)
                        ->orderBy('name')
                        ->get();
        
        return view('ngos.index', [
            'grouped' => $groupedByAlphabet,
            'focusAreas' => $focusAreas,
            'allNgos' => $ngos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ngo = Ngo::findOrFail($id);

        // Get projects where this NGO is the runner (implementing NGO)
        $projectsRunner = Project::where('runner_id', $id)
            ->with(['holder', 'trainings', 'reports'])
            ->latest()
            ->get();

        // Get projects where this NGO is the holder (funding NGO)
        $projectsHolder = Project::where('holder_id', $id)
            ->with(['runner', 'trainings', 'reports'])
            ->latest()
            ->get();

        return view('ngos.show', [
            'ngo' => $ngo,
            'projectsRunner' => $projectsRunner,
            'projectsHolder' => $projectsHolder,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
