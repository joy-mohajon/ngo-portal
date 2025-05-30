<?php

use App\Http\Controllers\FocusAreaController;
use App\Http\Controllers\NgoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTrainingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\FocalPersonController;
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


    // Project resource
//    Route::middleware(['auth', 'role:ngo|admin'])->group(function () {
    Route::get('projects/holder', [App\Http\Controllers\ProjectController::class, 'holderProjects'])->name('projects.holder');
    Route::get('projects/runner', [App\Http\Controllers\ProjectController::class, 'runnerProjects'])->name('projects.runner');
// });
    // Allow only admin and authority to access the main projects index
    // Route::middleware(['auth', 'role:admin|authority'])->group(function () {
        Route::resource('projects', ProjectController::class);
    // });

    

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



require __DIR__.'/auth.php';