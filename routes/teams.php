<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::prefix('teams')->controller(TeamController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('{id}', 'show');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'destroy');
    Route::post('{id}/assign-users', 'assignUsers');
});
