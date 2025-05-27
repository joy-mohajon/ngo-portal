<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    // NGO uploads testimonial supporting files
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'application_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);
        $filePath = $request->file('application_file')->store('testimonials', 'public');
        $testimonial = $project->testimonials()->create([
            'title' => $request->title,
            'description' => $request->description,
            'application_file' => $filePath,
            'requested_by' => Auth::user()->ngo->id ?? null,
            'date' => now(),
            'status' => 'pending',
        ]);
        return back()->with('success', 'Testimonial request submitted successfully.');
    }

    // Authority approves testimonial by uploading testimonial file
    public function approve(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'testimonial_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);
        $filePath = $request->file('testimonial_file')->store('testimonials', 'public');
        $testimonial->update([
            'testimonial_file' => $filePath,
            'status' => 'approved',
            'date' => now(),
        ]);
        return back()->with('success', 'Testimonial approved and file uploaded.');
    }

    // Authority rejects testimonial
    public function reject(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'rejected']);
        return back()->with('success', 'Testimonial rejected.');
    }

    // Authority or NGO can download application file
    public function downloadApplication(Testimonial $testimonial)
    {
        if (!$testimonial->application_file || !Storage::disk('public')->exists($testimonial->application_file)) {
            return back()->with('error', 'Application file not found.');
        }
        $filePath = storage_path('app/public/' . $testimonial->application_file);
        return response()->download($filePath);
    }

    public function downloadTestimonial(Testimonial $testimonial)
    {
        if (!$testimonial->testimonial_file || !Storage::disk('public')->exists($testimonial->testimonial_file)) {
            return back()->with('error', 'Testimonial file not found.');
        }
        $filePath = storage_path('app/public/' . $testimonial->testimonial_file);
        return response()->download($filePath);
    }
} 