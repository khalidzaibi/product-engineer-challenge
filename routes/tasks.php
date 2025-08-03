<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::apiResource('tasks', TaskController::class);
Route::controller(TaskController::class)->group(function () {
    Route::put('/tasks/{task}/status',  'updateStatus');
});
