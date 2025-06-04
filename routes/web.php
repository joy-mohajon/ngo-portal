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
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/api/gallery-images', [WelcomeController::class, 'getGalleryImages'])->name('api.gallery-images');
Route::get('/api/ngos-by-focus-area', [WelcomeController::class, 'getNgosByFocusArea'])->name('api.ngos-by-focus-area');
Route::get('/projects/{project}/details', [WelcomeController::class, 'projectDetails'])->name('projects.public.details');
Route::get('/public/gallery', [WelcomeController::class, 'galleryIndex'])->name('gallery.public.index');

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    // Check if user has NGO role and has an approved NGO
    $hasNgoRole = DB::table('model_has_roles')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->where('model_has_roles.model_id', $user->id)
        ->where('roles.name', 'ngo')
        ->exists();
    
    // If user is an NGO with approved status, redirect to NGO show page
    if ($hasNgoRole && $user->ngo && $user->ngo->status === 'approved') {
        return redirect()->route('ngos.show', $user->ngo->id);
    }
    
    // Otherwise show regular dashboard
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
    Route::get('/ngos/{ngo}/download-certificate', [NgoController::class, 'downloadCertificate'])->name('ngos.download-certificate');

    Route::resource('ngos', NgoController::class);


    // Project resource - allow only runner NGOs to edit their projects
    Route::get('projects/donner', [App\Http\Controllers\ProjectController::class, 'donnerProjects'])
        ->middleware(\App\Http\Middleware\NgoApproved::class)
        ->name('projects.donner');
    Route::get('projects/runner', [App\Http\Controllers\ProjectController::class, 'runnerProjects'])
        ->middleware(\App\Http\Middleware\NgoApproved::class)
        ->name('projects.runner');
    
    // Read-only routes for projects - restrict main index to admin and authority roles
    Route::get('projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');

    // Apply NGO approval middleware to project creation routes
    Route::get('projects/create', [App\Http\Controllers\ProjectController::class, 'create'])
        ->middleware(\App\Http\Middleware\NgoApproved::class)
        ->name('projects.create');
    Route::post('projects', [App\Http\Controllers\ProjectController::class, 'store'])
        ->middleware(\App\Http\Middleware\NgoApproved::class)
        ->name('projects.store');
    
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
        
        // Only approved NGO runners can modify students
        Route::get('students/create', [StudentAccessController::class, 'create'])
            ->middleware(\App\Http\Middleware\NgoApproved::class)
            ->name('students.create');
        Route::post('students', [StudentAccessController::class, 'store'])
            ->middleware(\App\Http\Middleware\NgoApproved::class)
            ->name('students.store');
        Route::get('students/{student}/edit', [StudentAccessController::class, 'edit'])
            ->middleware(\App\Http\Middleware\NgoApproved::class)
            ->name('students.edit');
        Route::put('students/{student}', [StudentAccessController::class, 'update'])
            ->middleware(\App\Http\Middleware\NgoApproved::class)
            ->name('students.update');
        Route::delete('students/{student}', [StudentAccessController::class, 'destroy'])
            ->middleware(\App\Http\Middleware\NgoApproved::class)
            ->name('students.destroy');
        
        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
    });

    Route::resource('focus-areas', FocusAreaController::class);

    Route::post('projects/{project}/testimonials', [TestimonialController::class, 'store'])->name('projects.testimonials.store');
    Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::get('testimonials/{testimonial}/download-application', [TestimonialController::class, 'downloadApplication'])->name('testimonials.download-application');
    Route::get('testimonials/{testimonial}/download-testimonial', [TestimonialController::class, 'downloadTestimonial'])->name('testimonials.download-testimonial');

    Route::resource('projects.galleries', ProjectGalleryController::class)
        ->only(['index', 'store', 'destroy'])
        ->middleware(\App\Http\Middleware\GalleryUploadCors::class);

    Route::resource('ngos.focal-persons', FocalPersonController::class)
        ->only(['index','store','update','destroy']);

});

// Test route to check middleware
Route::get('/test-middleware', function () {
    return 'Middleware test successful';
})->middleware([\App\Http\Middleware\ProjectRunnerMiddleware::class]);

// Test route for NgoApprovedMiddleware
Route::get('/test-ngo-middleware', function () {
    return 'NGO Approved Middleware test successful';
})->middleware(\App\Http\Middleware\NgoApproved::class);

// Debug route to check logo paths
Route::get('/debug-logo', function () {
    if (!Auth::check()) {
        return "Please login first";
    }
    
    $user = Auth::user();
    $ngo = $user->ngo;
    
    if (!$ngo) {
        return "No NGO found for this user";
    }
    
    $logoPath = $ngo->logo;
    $fullPath = storage_path('app/public/' . $logoPath);
    $publicPath = public_path('storage/' . $logoPath);
    $assetUrl = asset('storage/' . $logoPath);
    
    $result = [
        'ngo_id' => $ngo->id,
        'logo_path' => $logoPath,
        'full_path' => $fullPath,
        'full_path_exists' => file_exists($fullPath) ? 'Yes' : 'No',
        'public_path' => $publicPath,
        'public_path_exists' => file_exists($publicPath) ? 'Yes' : 'No',
        'asset_url' => $assetUrl,
        'storage_link_exists' => file_exists(public_path('storage')) ? 'Yes' : 'No',
    ];
    
    return response()->json($result);
})->middleware(['auth']);

// Add this route at the end of the file
Route::get('/test-mail', function () {
    try {
        \Illuminate\Support\Facades\Mail::mailer('smtp')->to('codecode2024@gmail.com')
            ->send(new \App\Mail\TestimonialRequestSubmitted(\App\Models\Testimonial::first()));
        return 'Mail sent successfully via SMTP. Check your inbox.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

require __DIR__.'/auth.php';