<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard route
    require __DIR__ . '/dashboard.php';
    // User routes
    require __DIR__ . '/users.php';
    // Task routes
    require __DIR__ . '/tasks.php';
    // Team routes
    require __DIR__ . '/teams.php';
});
