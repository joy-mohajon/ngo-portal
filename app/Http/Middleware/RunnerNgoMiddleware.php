<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class RunnerNgoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
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
        
        // For edit/update/delete routes with student parameter
        if ($request->route()->hasParameter('student')) {
            try {
                // Get the student ID from the route parameter
                $studentId = $request->route('student');
                
                // If it's already a model instance, use it directly
                if ($studentId instanceof Student) {
                    $student = $studentId;
                } else {
                    // Otherwise, find the student by ID
                    $student = Student::findOrFail($studentId);
                }
                
                // Check if the student belongs to any project where the NGO is the runner
                $hasAccess = DB::table('project_student')
                    ->join('projects', 'projects.id', '=', 'project_student.project_id')
                    ->where('project_student.student_id', $student->id)
                    ->where('projects.runner_id', $user->ngo->id)
                    ->exists();
                
                if (!$hasAccess) {
                    return redirect()->route('students.index')
                        ->with('error', 'You do not have permission to manage this student. You can only manage students in your runner projects.');
                }
            } catch (\Exception $e) {
                // Handle the error gracefully
                return redirect()->route('students.index')
                    ->with('error', 'Student not found or access denied.');
            }
        }
        
        return $next($request);
    }
}
