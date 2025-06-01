<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        // Auth middleware is applied at the route level
    }

    public function index(Request $request)
    {
        $query = Student::query()->with('projects');
        $user = Auth::user();
        
        // Check if user is an NGO
        $userIsNgo = false;
        $userNgo = null;
        
        if ($user) {
            // Check if user has NGO role using direct database query
            $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->where('roles.name', 'ngo')
                ->exists();
                
            if ($hasNgoRole && $user->ngo) {
                $userIsNgo = true;
                $userNgo = $user->ngo;
            }
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('national_id', 'like', "%{$search}%")
                ->orWhere('birth_certificate_number', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $projectId = $request->project_id;
            $query->whereHas('projects', function($q) use ($projectId) {
                $q->where('projects.id', $projectId);
            });
        }
        
        if ($request->has('batch') && $request->batch != '') {
            $query->where('batch', $request->batch);
        }
        
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }
        
        // IMPORTANT: If user is an NGO, always filter to only show students from projects where they are the runner
        // This should happen regardless of other filter conditions
        if ($userNgo) {
            $query->whereHas('projects', function($q) use ($userNgo) {
                $q->where('projects.runner_id', $userNgo->id);
            });
        }

        // Get students with pagination
        $students = $query->latest()->paginate(10)->withQueryString();

        // Get all distinct batches for the filter dropdown
        $batches = Student::distinct('batch')->whereNotNull('batch')->pluck('batch')->sort();

        // Get projects for the filter dropdown based on user role
        if ($userNgo) {
            // If NGO, only show projects where they are the runner
            $projects = Project::where('runner_id', $userNgo->id)->orderBy('title')->get();
        } else {
            // For other users, show all projects
            $projects = Project::orderBy('title')->get();
        }

        return view('students.index', compact('students', 'batches', 'projects', 'userNgo'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $ngo = $user->ngo;
        
        if (!$ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You must be associated with an NGO to create students.');
        }
        
        // Only show projects where the logged-in NGO is the runner
        $projects = Project::where('runner_id', $ngo->id)->orderBy('title')->get();
        
        if ($projects->isEmpty()) {
            return redirect()->route('students.index')
                ->with('error', 'You must have projects where you are the runner before you can add students.');
        }
        
        $selectedProjectId = $request->input('project_id');
        return view('students.create', compact('projects', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $ngo = $user->ngo;
        
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
            'batch' => 'nullable|string|max:255',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
            'project_enrollment_date' => 'nullable|date',
        ]);

        // Validate that all projects belong to the NGO user as runner
        if ($request->has('projects')) {
            $runnerProjects = Project::where('runner_id', $ngo->id)->pluck('id')->toArray();
            foreach ($request->projects as $projectId) {
                if (!in_array($projectId, $runnerProjects)) {
                    return redirect()->back()->with('error', 'You can only assign students to projects where you are the runner.')->withInput();
                }
            }
        }

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

        // Make sure batch is included in the validated data
        if ($request->has('batch')) {
            $validated['batch'] = $request->input('batch');
        }

        $student = Student::create($validated);

        // Sync projects with enrollment date
        if ($request->has('projects')) {
            $projectData = [];
            $projectEnrollmentDate = $request->input('project_enrollment_date') ?? now()->format('Y-m-d');
            
            foreach ($request->projects as $projectId) {
                $projectData[$projectId] = [
                    'enrollment_date' => $projectEnrollmentDate,
                    'status' => 'active'
                ];
            }
            
            $student->projects()->sync($projectData);
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $user = Auth::user();
        
        // Check if user is an NGO
        $userIsNgo = false;
        $userNgo = null;
        
        if ($user) {
            // Check if user has NGO role using direct database query
            $hasNgoRole = DB::table('model_has_roles')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.model_id', $user->id)
                ->where('roles.name', 'ngo')
                ->exists();
                
            if ($hasNgoRole && $user->ngo) {
                $userIsNgo = true;
                $userNgo = $user->ngo;
                
                // For NGO users, check if they have access to this student
                $hasAccess = $student->projects()->where('runner_id', $userNgo->id)->exists();
                
                if (!$hasAccess) {
                    return redirect()->route('students.index')
                        ->with('error', 'You do not have permission to view this student. You can only view students in your runner projects.');
                }
            }
        }
        
        $student->load('projects');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $user = Auth::user();
        $ngo = $user->ngo;
        
        if (!$ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You must be associated with an NGO to edit students.');
        }
        
        // Check if the student belongs to any project where the NGO is the runner
        $hasAccess = $student->projects()->where('runner_id', $ngo->id)->exists();
        
        if (!$hasAccess) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to edit this student. You can only manage students in your runner projects.');
        }
        
        // Only show projects where the logged-in NGO is the runner
        $projects = Project::where('runner_id', $ngo->id)->orderBy('title')->get();
        
        $student->load('projects');
        return view('students.edit', compact('student', 'projects'));
    }

    public function update(Request $request, Student $student)
    {
        $user = $request->user();
        $ngo = $user->ngo;
        
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
            'batch' => 'nullable|string|max:255',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
            'project_enrollment_date' => 'nullable|date',
        ]);

        // Validate that all projects belong to the NGO user as runner
        if ($request->has('projects')) {
            $runnerProjects = Project::where('runner_id', $ngo->id)->pluck('id')->toArray();
            foreach ($request->projects as $projectId) {
                if (!in_array($projectId, $runnerProjects)) {
                    return redirect()->back()->with('error', 'You can only assign students to projects where you are the runner.')->withInput();
                }
            }
        }

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

        // Make sure batch is included in the validated data
        if ($request->has('batch')) {
            $validated['batch'] = $request->input('batch');
        }

        $student->update($validated);

        // Sync projects with enrollment date
        if ($request->has('projects')) {
            $projectData = [];
            $projectEnrollmentDate = $request->input('project_enrollment_date') ?? now()->format('Y-m-d');
            
            // Get current project IDs
            $currentProjectIds = $student->projects->pluck('id')->toArray();
            
            foreach ($request->projects as $projectId) {
                if (in_array($projectId, $currentProjectIds)) {
                    // Keep existing enrollment date for projects that were already assigned
                    $pivot = $student->projects->find($projectId)->pivot;
                    $projectData[$projectId] = [
                        'enrollment_date' => $pivot->enrollment_date,
                        'status' => $pivot->status ?? 'active'
                    ];
                } else {
                    // For newly assigned projects, use the new enrollment date
                    $projectData[$projectId] = [
                        'enrollment_date' => $projectEnrollmentDate,
                        'status' => 'active'
                    ];
                }
            }
            
            $student->projects()->sync($projectData);
        }

        return redirect()->route('students.show', $student)->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $user = Auth::user();
        $ngo = $user->ngo;
        
        if (!$ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You must be associated with an NGO to delete students.');
        }
        
        // Check if the student belongs to any project where the NGO is the runner
        $hasAccess = $student->projects()->where('runner_id', $ngo->id)->exists();
        
        if (!$hasAccess) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to delete this student. You can only manage students in your runner projects.');
        }
        
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