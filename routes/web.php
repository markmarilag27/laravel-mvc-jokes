<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Jokes\GetJokeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 ****************************************************
 * API Routes
 ****************************************************
 */
Route::name('api.')->prefix('api')->group(function () {
    // Get jokes
    Route::get('jokes', GetJokeController::class)->name('jokes');
});
