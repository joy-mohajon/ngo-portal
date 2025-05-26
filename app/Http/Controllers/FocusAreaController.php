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

    public function create()
    {
        return view('focus-areas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:focus_areas,name',
            'description' => 'nullable|string',
        ]);
        $focusArea = FocusArea::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);
        return redirect()->route('focus-areas.index')->with('success', 'Focus Area created successfully.');
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
        ]);
        $focus_area->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);
        return redirect()->route('focus-areas.index')->with('success', 'Focus Area updated successfully.');
    }

    public function destroy(FocusArea $focus_area)
    {
        $focus_area->delete();
        return redirect()->route('focus-areas.index')->with('success', 'Focus Area deleted successfully.');
    }
} 