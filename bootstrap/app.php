<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SecurityHeaders;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->append(SecurityHeaders::class);

        $middleware->redirectUsersTo(function () {
            if (! auth()->check()) {
                return route('login');
            }

            return match (auth()->user()->role) {
                'direktur' => route('dirut.dashboard'),
                'office_boy' => route('office-boy.dashboard'),
                'karyawan' => route('karyawan.dashboard'),
                default => route('admin.dashboard'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();