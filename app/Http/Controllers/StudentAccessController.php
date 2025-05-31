<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentAccessController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has the NGO role using direct database query
        $hasNgoRole = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('roles.name', 'ngo')
            ->exists();
            
        if (!$hasNgoRole || !$user->ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to perform this action. Only NGO runners can manage students.');
        }
        
        // If we've made it here, the user is authorized to create students
        return app(StudentController::class)->create($request);
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has the NGO role using direct database query
        $hasNgoRole = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('roles.name', 'ngo')
            ->exists();
            
        if (!$hasNgoRole || !$user->ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to perform this action. Only NGO runners can manage students.');
        }
        
        // If we've made it here, the user is authorized to store students
        return app(StudentController::class)->store($request);
    }
    
    public function edit(Student $student)
    {
        $user = Auth::user();
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has the NGO role using direct database query
        $hasNgoRole = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('roles.name', 'ngo')
            ->exists();
            
        if (!$hasNgoRole || !$user->ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to perform this action. Only NGO runners can manage students.');
        }
        
        // Check if the student belongs to any project where the NGO is the runner
        $hasAccess = $student->projects()->where('runner_id', $user->ngo->id)->exists();
        
        if (!$hasAccess) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to edit this student. You can only manage students in your runner projects.');
        }
        
        // If we've made it here, the user is authorized to edit the student
        return app(StudentController::class)->edit($student);
    }
    
    public function update(Request $request, Student $student)
    {
        $user = Auth::user();
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has the NGO role using direct database query
        $hasNgoRole = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('roles.name', 'ngo')
            ->exists();
            
        if (!$hasNgoRole || !$user->ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to perform this action. Only NGO runners can manage students.');
        }
        
        // Check if the student belongs to any project where the NGO is the runner
        $hasAccess = $student->projects()->where('runner_id', $user->ngo->id)->exists();
        
        if (!$hasAccess) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to update this student. You can only manage students in your runner projects.');
        }
        
        // If we've made it here, the user is authorized to update the student
        return app(StudentController::class)->update($request, $student);
    }
    
    public function destroy(Student $student)
    {
        $user = Auth::user();
        
        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has the NGO role using direct database query
        $hasNgoRole = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('roles.name', 'ngo')
            ->exists();
            
        if (!$hasNgoRole || !$user->ngo) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to perform this action. Only NGO runners can manage students.');
        }
        
        // Check if the student belongs to any project where the NGO is the runner
        $hasAccess = $student->projects()->where('runner_id', $user->ngo->id)->exists();
        
        if (!$hasAccess) {
            return redirect()->route('students.index')
                ->with('error', 'You do not have permission to delete this student. You can only manage students in your runner projects.');
        }
        
        // If we've made it here, the user is authorized to delete the student
        return app(StudentController::class)->destroy($student);
    }
} 