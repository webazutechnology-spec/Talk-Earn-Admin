<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
        ]);

        // $middleware->web([
        //     // Add global web middleware here if needed
        // ]);

        // $middleware->api([
        //     // Add global API middleware here if needed
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
