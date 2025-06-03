<?php

namespace App\Http\Controllers;

use App\Http\Requests\NgoRequest;
use App\Models\FocusArea;
use App\Models\Ngo;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        try {
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

            // Handle file uploads with error checking
            if (!$request->hasFile('logo') || !$request->file('logo')->isValid()) {
                return redirect()->back()->withInput()->withErrors(['logo' => 'The logo file is invalid or failed to upload.']);
            }

            if (!$request->hasFile('certificate_path') || !$request->file('certificate_path')->isValid()) {
                return redirect()->back()->withInput()->withErrors(['certificate_path' => 'The certificate file is invalid or failed to upload.']);
            }

            try {
                // Store the logo file
                $logoPath = $request->file('logo')->store('logos', 'public');
                
                if (!$logoPath) {
                    return redirect()->back()->withInput()->withErrors(['logo' => 'Failed to save the logo. Please try again.']);
                }
                
                // Ensure the file is readable
                $fullLogoPath = storage_path('app/public/' . $logoPath);
                chmod($fullLogoPath, 0644);
                
                // Store the certificate file
                $certificatePath = $request->file('certificate_path')->store('certificates', 'public');
                
                if (!$certificatePath) {
                    return redirect()->back()->withInput()->withErrors(['certificate_path' => 'Failed to save the certificate. Please try again.']);
                }
                
                // Ensure the file is readable
                $fullCertPath = storage_path('app/public/' . $certificatePath);
                chmod($fullCertPath, 0644);
                
                // Clear any cached versions of the files
                clearstatcache(true, $fullLogoPath);
                clearstatcache(true, $fullCertPath);
            } catch (\Exception $e) {
                Log::error('File upload error: ' . $e->getMessage());
                return redirect()->back()->withInput()->withErrors(['error' => 'Error saving files: ' . $e->getMessage()]);
            }

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
            
            // Check if user has NGO role, if not assign it
            $user = $request->user();
            if (!$user->hasRole('ngo')) {
                $user->assignRole('ngo');
            }

            // Force refresh of the NGO relationship
            $request->user()->load('ngo');

            // Redirect to dashboard with success message
            return redirect()->route('dashboard')->with('success', 'Your NGO registration has been submitted and is pending approval. You will be notified once it is approved.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('NGO creation error: ' . $e->getMessage());
            
            // Return with a user-friendly error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ngo $ngo)
    {
        $allProjects = \App\Models\Project::where(function($q) use ($ngo) {
            $q->where('donner_id', $ngo->id)
              ->orWhere('runner_id', $ngo->id);
        })
        ->with([
            'donner:id,name,logo',
            'runner:id,name,logo',
            'trainings' => fn($q) => $q->latest()->limit(5),
            'reports' => fn($q) => $q->latest()->limit(3)
        ])
        ->latest()->get();

        // Run & Funded By (both)
        $projectsBoth = $allProjects->filter(function($project) use ($ngo) {
            return $project->donner_id == $ngo->id && $project->runner_id == $ngo->id;
        });

        // Run By (runner only, not both)
        $projectsRunner = $allProjects->filter(function($project) use ($ngo) {
            return $project->runner_id == $ngo->id && $project->donner_id != $ngo->id;
        });

        // Funded By (donner only, not both)
        $projectsDonner = $allProjects->filter(function($project) use ($ngo) {
            return $project->donner_id == $ngo->id && $project->runner_id != $ngo->id;
        });

        return view('ngos.show', compact('ngo', 'projectsRunner', 'projectsDonner', 'projectsBoth'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ngo = Ngo::with('focusAreas')->findOrFail($id);
        $focusAreas = FocusArea::orderBy('name')->get();
        return view('ngos.edit', compact('ngo', 'focusAreas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $ngo = Ngo::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'short_name' => 'required|string|max:255',
                'website' => 'nullable|url',
                'location' => 'required|string|max:255',
                'focus_areas' => 'nullable|array',
                'focus_areas.*' => 'exists:focus_areas,id',
                'focus_activities' => 'nullable|array',
                'focus_activities.*' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100',
                'certificate_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
                'established_year' => 'required|string|max:10',
                'description' => 'nullable|string',
            ]);

            // Handle file uploads
            if ($request->hasFile('logo')) {
                if (!$request->file('logo')->isValid()) {
                    return redirect()->back()->withInput()->withErrors(['logo' => 'The logo file is invalid or failed to upload.']);
                }
                
                try {
                    // Store the file
                    $logoPath = $request->file('logo')->store('logos', 'public');
                    
                    if (!$logoPath) {
                        return redirect()->back()->withInput()->withErrors(['logo' => 'Failed to save the logo. Please try again.']);
                    }
                    
                    // Ensure the file is readable
                    $fullPath = storage_path('app/public/' . $logoPath);
                    chmod($fullPath, 0644);
                    
                    $ngo->logo = $logoPath;
                    
                    // Clear any cached versions of the logo
                    clearstatcache(true, $fullPath);
                } catch (\Exception $e) {
                    Log::error('Logo upload error: ' . $e->getMessage());
                    return redirect()->back()->withInput()->withErrors(['logo' => 'Error saving logo: ' . $e->getMessage()]);
                }
            }
            
            if ($request->hasFile('certificate_path')) {
                if (!$request->file('certificate_path')->isValid()) {
                    return redirect()->back()->withInput()->withErrors(['certificate_path' => 'The certificate file is invalid or failed to upload.']);
                }
                $certificatePath = $request->file('certificate_path')->store('certificates', 'public');
                if (!$certificatePath) {
                    return redirect()->back()->withInput()->withErrors(['certificate_path' => 'Failed to save the certificate. Please try again.']);
                }
                $ngo->certificate_path = $certificatePath;
            }

            $ngo->name = $validated['name'];
            $ngo->email = $validated['email'];
            $ngo->short_name = $validated['short_name'];
            $ngo->website = $validated['website'] ?? null;
            $ngo->location = $validated['location'];
            $ngo->focus_activities = $validated['focus_activities'] ?? [];
            $ngo->established_year = $validated['established_year'];
            $ngo->description = $validated['description'] ?? null;
            $ngo->save();

            // Sync focus areas
            $ngo->focusAreas()->sync($validated['focus_areas'] ?? []);

            // Force refresh of the NGO relationship
            $request->user()->load('ngo');

            return redirect()->route('ngos.show', $ngo->id)->with('success', 'NGO updated successfully.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('NGO update error: ' . $e->getMessage());
            
            // Return with a user-friendly error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the NGO. Please try again.');
        }
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
        $pendingCount = Ngo::where('status', 'pending')->count();
        
        $ngos = Ngo::where('status', 'pending')
            ->with(['user', 'focusAreas'])
            ->latest()
            ->paginate(10);

        return view('ngos.pending', ['ngos' => $ngos, 'pendingCount' => $pendingCount]);
    }

    /**
     * Approve an NGO.
     */
    public function approve(Ngo $ngo)
    {
        $ngo->update(['status' => 'approved']);
        
        // Notify the user (you can implement a proper notification system later)
        // For now, we'll just flash a message for the authority user
        $message = "NGO '{$ngo->name}' has been approved successfully! The NGO owner has been notified.";

        return redirect()->route('ngos.pending')
            ->with('success', $message);
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