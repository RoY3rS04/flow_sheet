<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function (): Response {
        return Inertia::render('Dashboard');
    });

    Route::get('/datasets', function (): Response {
        return Inertia::render('Datasets');
    });

    Route::get('/workflows', function (): Response {
        return Inertia::render('Workflows');
    });

    Route::get('/reports', function (): Response {
        return Inertia::render('Reports');
    });

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::get('/login', [UserController::class, 'login'])->name('login');

    Route::middleware(['throttle:auth'])->group(function () {
        Route::post('/register', [UserController::class, 'store']);
        Route::post('/login', [UserController::class, 'authenticate']);
    });
});
