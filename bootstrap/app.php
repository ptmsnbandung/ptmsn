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
        $middleware->redirectTo(
            guests: function (\Illuminate\Http\Request $request) {
                if ($request->is('portal*')) {
                    return route('portal.login');
                }
                return route('admin.login');
            }
        );

        $middleware->alias([
            'portal.timeout' => \App\Http\Middleware\CustomerPortalSessionTimeout::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'coverage/check',
            'contact',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
