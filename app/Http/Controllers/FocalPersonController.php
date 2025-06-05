<?php

namespace App\Http\Controllers;

use App\Models\FocalPerson;
use App\Models\Ngo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FocalPersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Ngo $ngo)
    {
        $focalPersons = $ngo->focalPersons()->whereNull('focal_persons.deleted_at')->get();
        return response()->json($focalPersons);
    }

    public function store(Request $request, Ngo $ngo)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:focal_persons,email',
            'designation' => 'required|string|max:255',
        ]);
        $focalPerson = FocalPerson::create($validated);
        $ngo->focalPersons()->attach($focalPerson->id);
        return redirect()->back()->with('success', 'Focal person added successfully.');
    }

    public function update(Request $request, Ngo $ngo, FocalPerson $focalPerson)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:focal_persons,email,' . $focalPerson->id,
            'designation' => 'required|string|max:255',
        ]);
        $focalPerson->update($validated);
        return redirect()->back()->with('success', 'Focal person updated successfully.');
    }

    public function destroy(Ngo $ngo, FocalPerson $focalPerson)
    {
        $ngo->focalPersons()->detach($focalPerson->id);
        $focalPerson->delete();
        return redirect()->back()->with('success', 'Focal person deleted successfully.');
    }
} 