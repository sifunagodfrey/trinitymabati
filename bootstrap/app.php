<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ---------------
        // Role-based portal access guard
        // ---------------
        $middleware->alias([
            'role'             => \App\Http\Middleware\RoleMiddleware::class,
            'remember.session' => \App\Http\Middleware\EnforceRememberSession::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);

        // ---------------
        // Record frontend page visits to su_visitors_logs
        // ---------------
        $middleware->appendToGroup('web', \App\Http\Middleware\TrackVisitor::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
