<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
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
    Route::post('projects/{project}/upload-reports', [ReportController::class, 'store'])
        ->name('projects.upload-reports');
    Route::get('projects/{project}/download-reports', [ReportController::class, 'downloadProjectReports'])
        ->name('projects.download-reports');
        
    // Reports
    Route::resource('reports', ReportController::class)->except(['edit', 'update']);

});



require __DIR__.'/auth.php';