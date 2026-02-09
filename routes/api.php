<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TopicController;
use App\Models\Topic;
use Illuminate\Container\Attributes\Auth;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(PartnerController::class)->group(function(){
        Route::get('profile', 'profile');

        Route::prefix('partners')->group(function(){
            Route::get('', 'index');
            Route::post('', 'store');
            Route::get('/{id}', 'show');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
    Route::prefix('courses')->controller(CourseController::class)->group(function(){
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('/{id}', 'show');
        Route::patch('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
    Route::prefix('topics')->controller(TopicController::class)->group(function(){
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('/{id}', 'show');
        Route::patch('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('enrollments')->controller(EnrollmentController::class)->group(function(){
        Route::get('', 'index');
        Route::post('', 'store');
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

