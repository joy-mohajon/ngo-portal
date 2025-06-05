<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectAccessController extends Controller
{
    public function edit(Project $project)
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
        
        // Check if the NGO is the runner for this project
        if ($project->runner_id != $user->ngo->id) {
            return redirect()->route('projects.index')
                ->with('error', 'You do not have permission to manage this project. You can only manage projects where you are the runner.');
        }
        
        // If we've made it here, the user is authorized to edit the project
        return app(ProjectController::class)->edit($project);
    }
    
    public function update(Request $request, Project $project)
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
        
        // Check if the NGO is the runner for this project
        if ($project->runner_id != $user->ngo->id) {
            return redirect()->route('projects.index')
                ->with('error', 'You do not have permission to manage this project. You can only manage projects where you are the runner.');
        }
        
        // If we've made it here, the user is authorized to update the project
        return app(ProjectController::class)->update($request, $project);
    }
    
    public function destroy(Project $project)
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
        
        // Check if the NGO is the runner for this project
        if ($project->runner_id != $user->ngo->id) {
            return redirect()->route('projects.index')
                ->with('error', 'You do not have permission to manage this project. You can only manage projects where you are the runner.');
        }
        
        // If we've made it here, the user is authorized to delete the project
        return app(ProjectController::class)->destroy($project);
    }
} 