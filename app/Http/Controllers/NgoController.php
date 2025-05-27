<?php

namespace App\Http\Controllers;

use App\Http\Requests\NgoRequest;
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
        // Pass the logged-in user's name and email to the view
        $user = request()->user();
        $focusAreas = \App\Models\FocusArea::orderBy('name')->get();
        return view('ngos.create', [
            'userName' => $user ? $user->name : '',
            'userEmail' => $user ? $user->email : '',
            'focusAreas' => $focusAreas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NgoRequest $request)
    {
        // Generate registration_id
        $validated = $request->validated();
        $shortName = strtoupper($validated['short_name']);
        $namePart = strtoupper(substr(preg_replace('/\s+/', '', $validated['name']), 0, 2));
        $year = $validated['established_year'];
        $yearPart = substr($year, -2);
        $registrationId = 'NGO-' . $shortName . '-' . $namePart . $yearPart . '-' . $year;
        
        // Ensure uniqueness
        $i = 1;
        $baseRegistrationId = $registrationId;
        while (\App\Models\Ngo::where('registration_id', $registrationId)->exists()) {
            $registrationId = $baseRegistrationId . '-' . $i;
            $i++;
        }

        // Handle file uploads
        $logoPath = $request->file('logo')->store('logos', 'public');
        $certificatePath = $request->file('certificate_path')->store('certificates', 'public');

        $ngo = Ngo::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'short_name' => $validated['short_name'],
            'description' => $validated['description'] ?? null,
            'registration_id' => $registrationId,
            'email' => $validated['email'],
            'website' => $validated['website'] ?? null,
            'location' => $validated['location'],
            'focus_activities' => $validated['focus_activities'] ?? [],
            'logo' => $logoPath,
            'certificate_path' => $certificatePath,
            'established_year' => $year,
            'status' => 'pending',
        ]);

        // Attach focus areas if any
        if (!empty($validated['focus_areas'])) {
            $ngo->focusAreas()->sync($validated['focus_areas']);
        }

        return redirect()->route('ngos.index')->with('success', 'NGO created successfully.');
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

    /**
     * Display a listing of pending NGOs.
     */
    public function pending()
    {
        $ngos = Ngo::where('status', 'pending')
            ->with(['user', 'focusAreas'])
            ->latest()
            ->paginate(10);

        return view('ngos.pending', ['ngos' => $ngos]);
    }

    /**
     * Approve an NGO.
     */
    public function approve(Ngo $ngo)
    {
        $ngo->update(['status' => 'approved']);

        return redirect()->route('ngos.pending')
            ->with('success', 'NGO approved successfully!');
    }

    /**
     * Reject an NGO.
     */
    public function reject(Ngo $ngo)
    {
        $ngo->update(['status' => 'rejected']);

        return redirect()->route('ngos.pending')
            ->with('success', 'NGO rejected successfully!');
    }
}