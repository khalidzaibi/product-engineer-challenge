<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show');
    Route::post('/users', 'store');
    Route::put('/users/{user}', 'update');
    Route::delete('/users/{user}', 'destroy');
});
