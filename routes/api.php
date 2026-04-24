<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Keluarga\KeluargaController;
use App\Http\Controllers\Api\ProgressMateri\ProgressMateriController;
use App\Http\Controllers\Api\Skrining\SkriningController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->middleware('throttle:5,1');

        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:10,1');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::get('/me', [AuthController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        });

        Route::prefix('materi')->group(function () {
            Route::get('/progress', [ProgressMateriController::class, 'index']);
            Route::post('/progress', [ProgressMateriController::class, 'complete']);
        });

        Route::apiResource('keluarga', KeluargaController::class);
        Route::apiResource('skrining', SkriningController::class);
        // Route::post('keluarga', [KeluargaController::class, 'store']);
    });
});
