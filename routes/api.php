<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::apiResource('tasks', TaskController::class);
    Route::get('/tasks-trashed', [TaskController::class, 'trashed']);
    Route::patch('/tasks/{id}/restore', [TaskController::class, 'restore']);
    Route::delete('/tasks/{id}/force-delete', [TaskController::class, 'forceDelete']);
});
