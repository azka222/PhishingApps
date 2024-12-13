<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Buat instance aplikasi
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware global
        $middleware->add(\Illuminate\Session\Middleware\StartSession::class);
        $middleware->add(\Illuminate\View\Middleware\ShareErrorsFromSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handler exception jika diperlukan
    })->create();
