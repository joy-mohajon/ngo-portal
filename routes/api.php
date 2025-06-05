<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProjectController;

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

// Gallery images API endpoint
Route::get('/gallery-images', [WelcomeController::class, 'getGalleryImages']);

// NGO filtering by focus area
Route::get('/ngos-by-focus-area', [WelcomeController::class, 'getNgosByFocusArea']);

// Projects API endpoint - restricted to admin and authority roles
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/projects', [ProjectController::class, 'apiIndex']);
    Route::get('/projects/{project}', [ProjectController::class, 'apiShow']);
    Route::post('/projects', [ProjectController::class, 'apiStore']);
    Route::put('/projects/{project}', [ProjectController::class, 'apiUpdate']);
    Route::delete('/projects/{project}', [ProjectController::class, 'apiDestroy']);
});
