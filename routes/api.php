<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartnerController;
use Illuminate\Container\Attributes\Auth;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/partners', [PartnerController::class, 'index']);
    Route::get('/partners/{id}', [PartnerController::class, 'show']);
    Route::post('/partners', [PartnerController::class, 'store']);
    Route::patch('/partners/{id}', [PartnerController::class, 'update']);
    Route::delete('/partners/{id}', [PartnerController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

