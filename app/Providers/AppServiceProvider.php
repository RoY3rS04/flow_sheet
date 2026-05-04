<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)
                ->by(\Str::lower((string) $request->input('email')).'|'.$request->ip())
                ->response(function (Request $request, array $headers) {
                    $seconds = $headers['Retry-After'] ?? 60;

                    return back()
                        ->withErrors([
                            'error' => "Too many attempts. Try again in {$seconds} seconds.",
                        ])
                        ->withInput($request->except('password'));
                });
        });
    }
}
