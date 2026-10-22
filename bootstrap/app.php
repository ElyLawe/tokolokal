<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Kasir;
use App\Http\Middleware\CekRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Menambahkan path routing API
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api', // Menentukan prefix URL untuk API (misal: /api/books)
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Menambahkan konfigurasi group middleware untuk API (Sanctum Stateful & Throttling)
        $middleware->appendToGroup('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Alias middleware custom Anda
        $middleware->alias([
            'admin' => Admin::class,
            'kasir' => Kasir::class,
            'role'  => CekRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();