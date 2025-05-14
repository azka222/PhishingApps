<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureEmployee;
use App\Http\Middleware\EnsureNotEmployee;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'employee'    => \App\Http\Middleware\EnsureEmployee::class,
            'notEmployee' => \App\Http\Middleware\ensureNotEmployee::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })->create();
