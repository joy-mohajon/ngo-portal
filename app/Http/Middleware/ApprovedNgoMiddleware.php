<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ApprovedNgoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Check if user has NGO role using direct database query
        $hasNgoRole = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('roles.name', 'ngo')
            ->exists();
            
        // If user doesn't have NGO role, they shouldn't be accessing these routes
        if (!$hasNgoRole) {
            return redirect()->route('dashboard')
                ->with('error', 'You need NGO privileges to access this feature.');
        }
        
        // If user doesn't have an NGO yet
        if (!$user->ngo) {
            return redirect()->route('ngos.create')
                ->with('error', 'You need to register your NGO before accessing this feature.');
        }
        
        // If user's NGO is not approved
        if ($user->ngo->status !== 'approved') {
            return redirect()->route('dashboard')
                ->with('error', 'Your NGO registration is pending approval. You will be able to access this feature once approved.');
        }
        
        return $next($request);
    }
} 