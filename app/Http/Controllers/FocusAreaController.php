<?php

namespace App\Http\Controllers;

use App\Models\FocusArea;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FocusAreaController extends Controller
{
    public function index()
    {
        $focusAreas = FocusArea::orderBy('name')->paginate(12);
        return view('focus-areas.index', compact('focusAreas'));
    }

    public function create(Request $request)
    {
        $redirectUrl = $request->input('redirect_url', route('focus-areas.index'));
        return view('focus-areas.create', compact('redirectUrl'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:focus_areas,name',
            'description' => 'nullable|string',
            'type' => 'required|in:Project,NGO',
            'redirect_url' => 'nullable|string',
        ]);
        
        $focusArea = FocusArea::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
        ]);
        
        // Determine where to redirect
        $redirectUrl = $validated['redirect_url'] ?? route('focus-areas.index');
        
        return redirect($redirectUrl)->with('success', 'Focus Area created successfully.');
    }

    public function edit(FocusArea $focus_area)
    {
        return view('focus-areas.edit', ['focusArea' => $focus_area]);
    }

    public function update(Request $request, FocusArea $focus_area)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:focus_areas,name,' . $focus_area->id,
            'description' => 'nullable|string',
            'type' => 'required|in:Project,NGO',
        ]);
        $focus_area->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
        ]);
        return redirect()->route('focus-areas.index')->with('success', 'Focus Area updated successfully.');
    }

    public function destroy(FocusArea $focus_area)
    {
        $focus_area->delete();
        return redirect()->route('focus-areas.index')->with('success', 'Focus Area deleted successfully.');
    }
} 