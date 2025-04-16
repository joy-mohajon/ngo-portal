<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Trainings resource
    Route::resource('trainings', TrainingController::class);
    
    // Projects resource
    Route::resource('projects', ProjectController::class);
    
    // Project trainings
    Route::get('projects/{project}/trainings', [App\Http\Controllers\ProjectTrainingsController::class, 'index'])
        ->name('projects.trainings');
});

// API Routes
// Route::prefix('api')->group(function () {
//     // Project API endpoints
//     Route::get('/projects', [ProjectController::class, 'apiIndex']);
//     Route::get('/projects/{project}', [ProjectController::class, 'apiShow']);
//     Route::post('/projects', [ProjectController::class, 'apiStore']);
//     Route::put('/projects/{project}', [ProjectController::class, 'apiUpdate']);
//     Route::delete('/projects/{project}', [ProjectController::class, 'apiDestroy']);
// });

require __DIR__.'/auth.php';