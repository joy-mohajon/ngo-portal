<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

class ProjectRunnerMiddleware
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
            return redirect()->route('projects.index')
                ->with('error', 'You do not have permission to perform this action. Only NGO runners can manage their projects.');
        }
        
        // For edit/update/delete routes with project parameter
        if ($request->route()->hasParameter('project')) {
            try {
                // Get the project ID from the route parameter
                $projectId = $request->route('project');
                
                // If it's already a model instance, use it directly
                if ($projectId instanceof Project) {
                    $project = $projectId;
                } else {
                    // Otherwise, find the project by ID
                    $project = Project::findOrFail($projectId);
                }
                
                // Check if the NGO is the runner for this project
                if ($project->runner_id != $user->ngo->id) {
                    return redirect()->route('projects.index')
                        ->with('error', 'You do not have permission to manage this project. You can only manage projects where you are the runner.');
                }
            } catch (\Exception $e) {
                // Handle the error gracefully
                return redirect()->route('projects.index')
                    ->with('error', 'Project not found or access denied.');
            }
        }
        
        return $next($request);
    }
} 