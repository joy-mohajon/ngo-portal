<?php

use App\Http\Controllers\NgoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTrainingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
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
    // Route::resource('projects.trainings', TrainingController::class);
    
    // Projects resource
    Route::resource('ngos', NgoController::class);

    // Projects resource
    Route::resource('projects', ProjectController::class);
    

    // Complete nested resource route with all actions
    Route::resource('projects.trainings', ProjectTrainingController::class)
    ->shallow()->names('projects.trainings');

    // Route::get('projects/{project}/trainings', [App\Http\Controllers\ProjectTrainingController::class, 'index'])
    //     ->name('projects.trainings');
    Route::post('projects/{project}/upload-reports', [ReportController::class, 'store'])
        ->name('projects.upload-reports');
    Route::get('projects/{project}/download-reports', [ReportController::class, 'downloadProjectReports'])
        ->name('projects.download-reports');
        
    // Reports
    Route::resource('reports', ReportController::class)->except(['edit', 'update']);

    Route::resource('students', StudentController::class);

});



require __DIR__.'/auth.php';