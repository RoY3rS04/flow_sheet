<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {

        if(Auth::user()->hasVerifiedEmail()){
            return back();
        }

        return Inertia::render('Email/Verify');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:3,5'])->name('verification.send');

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
