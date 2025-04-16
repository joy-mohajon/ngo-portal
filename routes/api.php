<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TrainingController;
use App\Models\Project;
use App\Models\Training;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API endpoints for testing
Route::prefix('public')->group(function () {
    // Projects endpoints
    Route::get('/projects', function () {
        $projects = Project::with(['holder', 'runner'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    });

    Route::get('/projects/{project}', function (Project $project) {
        $project->load(['holder', 'runner']);
        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    });

    // Trainings endpoints
    Route::get('/trainings', function () {
        $trainings = Training::with(['project', 'organizer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $trainings
        ]);
    });

    Route::get('/trainings/{training}', function (Training $training) {
        $training->load(['project', 'organizer']);
        return response()->json([
            'success' => true,
            'data' => $training
        ]);
    });

    // Project trainings endpoint
    Route::get('/projects/{project}/trainings', function (Project $project) {
        $trainings = $project->trainings()
            ->with('organizer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return response()->json([
            'success' => true,
            'project' => $project->only(['id', 'title']),
            'data' => $trainings
        ]);
    });

    // Statistics endpoint
    Route::get('/stats', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'projects' => [
                    'total' => Project::count(),
                    'active' => Project::where('status', 'active')->count(),
                    'completed' => Project::where('status', 'completed')->count(),
                    'pending' => Project::where('status', 'pending')->count(),
                    'suspended' => Project::where('status', 'suspended')->count(),
                ],
                'trainings' => [
                    'total' => Training::count(),
                    'upcoming' => Training::where('status', 'upcoming')->count(),
                    'ongoing' => Training::where('status', 'ongoing')->count(),
                    'completed' => Training::where('status', 'completed')->count(),
                    'cancelled' => Training::where('status', 'cancelled')->count(),
                ]
            ]
        ]);
    });
});

// Protected API endpoints (require authentication)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Project API endpoints
    Route::apiResource('projects', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    
    // Training API endpoints
    Route::apiResource('trainings', TrainingController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    
    // Project trainings endpoint
    Route::get('/projects/{project}/trainings', [ProjectController::class, 'trainings']);
});

// Test endpoint that requires authentication
Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
    return response()->json([
        'message' => 'You are authenticated!',
        'user' => $request->user()
    ]);
});

// Public endpoint for testing
Route::get('/public', function () {
    return response()->json(['message' => 'This is a public endpoint']);
}); 