<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->with('projects');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('national_id', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('project_id')) {
            $projectId = $request->project_id;
            $query->whereHas('projects', function($q) use ($projectId) {
                $q->where('projects.id', $projectId);
            });
        }

        $students = $query->latest()->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $ngo = $user && $user->hasRole('ngo') ? $user->ngo : null;
        $projects = collect();
        if ($ngo) {
            $projects = \App\Models\Project::where('runner_id', $ngo->id)
                ->get();
        }
        $selectedProjectId = $request->input('project_id');
        return view('students.create', compact('projects', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'national_id' => 'nullable|string|max:50',
            'national_id_file' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'birth_certificate_number' => 'nullable|string|max:50',
            'birth_certificate_file' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_address' => 'nullable|string',
            'enrollment_date' => 'nullable|date',
            'education_level' => 'nullable|string|max:255',
            'education_institution' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,graduated,dropped',
            'notes' => 'nullable|string',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }
        if ($request->hasFile('national_id_file')) {
            $validated['national_id_file'] = $request->file('national_id_file')->store('students/documents', 'public');
        }
        if ($request->hasFile('birth_certificate_file')) {
            $validated['birth_certificate_file'] = $request->file('birth_certificate_file')->store('students/documents', 'public');
        }

        $student = Student::create($validated);

        // Sync projects
        if ($request->has('projects')) {
            $student->projects()->sync($request->projects);
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load('projects');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $projects = Project::all();
        $student->load('projects');
        return view('students.edit', compact('student', 'projects'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:students,email,'.$student->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'national_id' => 'nullable|string|max:50',
            'national_id_file' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'birth_certificate_number' => 'nullable|string|max:50',
            'birth_certificate_file' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_address' => 'nullable|string',
            'enrollment_date' => 'nullable|date',
            'education_level' => 'nullable|string|max:255',
            'education_institution' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,graduated,dropped',
            'notes' => 'nullable|string',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $validated['photo'] = $request->file('photo')->store('students/photos', 'public');
        }

        if ($request->hasFile('national_id_file')) {
            if ($student->national_id_file) {
                Storage::disk('public')->delete($student->national_id_file);
            }
            $validated['national_id_file'] = $request->file('national_id_file')->store('students/documents', 'public');
        }

        if ($request->hasFile('birth_certificate_file')) {
            if ($student->birth_certificate_file) {
                Storage::disk('public')->delete($student->birth_certificate_file);
            }
            $validated['birth_certificate_file'] = $request->file('birth_certificate_file')->store('students/documents', 'public');
        }

        $student->update($validated);

        // Sync projects
        $student->projects()->sync($request->projects ?? []);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        // Delete associated files
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        if ($student->national_id_file) {
            Storage::disk('public')->delete($student->national_id_file);
        }
        if ($student->birth_certificate_file) {
            Storage::disk('public')->delete($student->birth_certificate_file);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}