<?php

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
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function (): Response {
        return Inertia::render('Auth/Login');
    })->name('login');
    Route::get('/register', function (): Response {
        return Inertia::render('Auth/Register');
    })->name('register');
});
