<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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