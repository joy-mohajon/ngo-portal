<?php

use App\Http\Controllers\FocusAreaController;
use App\Http\Controllers\NgoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectAccessController;
use App\Http\Controllers\ProjectTrainingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\FocalPersonController;
use App\Http\Controllers\StudentAccessController;
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
    
    // ngo resource
    // Approval routes
    Route::get('/pending', [NgoController::class, 'pending'])->name('ngos.pending');
    Route::post('/{ngo}/approve', [NgoController::class, 'approve'])->name('ngos.approve');
    Route::post('/{ngo}/reject', [NgoController::class, 'reject'])->name('ngos.reject');

    Route::resource('ngos', NgoController::class);


    // Project resource - allow only runner NGOs to edit their projects
    Route::get('projects/holder', [App\Http\Controllers\ProjectController::class, 'holderProjects'])->name('projects.holder');
    Route::get('projects/runner', [App\Http\Controllers\ProjectController::class, 'runnerProjects'])->name('projects.runner');
    
    // Read-only routes for projects
    Route::get('projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');
    
    // Runner-only routes - can only be accessed by the NGO that is the runner of the project
    // Using ProjectAccessController to handle permissions instead of middleware
    Route::get('projects/{project}/edit', [App\Http\Controllers\ProjectAccessController::class, 'edit'])->name('projects.edit');
    Route::put('projects/{project}', [App\Http\Controllers\ProjectAccessController::class, 'update'])->name('projects.update');
    Route::delete('projects/{project}', [App\Http\Controllers\ProjectAccessController::class, 'destroy'])->name('projects.destroy');

    

    // Complete nested resource route with all actions
    Route::resource('projects.trainings', ProjectTrainingController::class)
    ->shallow()->names('projects.trainings');

    // Route::get('projects/{project}/trainings', [App\Http\Controllers\ProjectTrainingController::class, 'index'])
    //     ->name('projects.trainings');
    Route::post('projects/{project}/upload-reports', [ReportController::class, 'store'])
        ->name('projects.upload-reports');
    Route::get('projects/{project}/download-reports', [ReportController::class, 'downloadProjectReports'])
        ->name('projects.download-reports');
    Route::get('reports/{report}/download', [ReportController::class, 'download'])
        ->name('reports.download');
        
    // Reports
    Route::resource('reports', ReportController::class)->except(['edit', 'update']);

    // Students routes - separate read and write operations
    Route::middleware(['auth'])->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        
        // Only NGO runners can modify students - using StudentAccessController instead of middleware
        Route::get('students/create', [StudentAccessController::class, 'create'])->name('students.create');
        Route::post('students', [StudentAccessController::class, 'store'])->name('students.store');
        Route::get('students/{student}/edit', [StudentAccessController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [StudentAccessController::class, 'update'])->name('students.update');
        Route::delete('students/{student}', [StudentAccessController::class, 'destroy'])->name('students.destroy');
        
        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
    });

    Route::resource('focus-areas', FocusAreaController::class);

    Route::post('projects/{project}/testimonials', [TestimonialController::class, 'store'])->name('projects.testimonials.store');
    Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::get('testimonials/{testimonial}/download-application', [TestimonialController::class, 'downloadApplication'])->name('testimonials.download-application');
    Route::get('testimonials/{testimonial}/download-testimonial', [TestimonialController::class, 'downloadTestimonial'])->name('testimonials.download-testimonial');

    Route::resource('projects.galleries', ProjectGalleryController::class)
        ->only(['index', 'store', 'destroy']);

    Route::resource('ngos.focal-persons', FocalPersonController::class)
        ->only(['index','store','update','destroy']);

});

// Test route to check middleware
Route::get('/test-middleware', function () {
    return 'Middleware test successful';
})->middleware([\App\Http\Middleware\ProjectRunnerMiddleware::class]);

require __DIR__.'/auth.php';