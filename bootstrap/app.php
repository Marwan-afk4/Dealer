<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Cookie\Middleware\EncryptCookies;
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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            //sanctum middleware enures authenticated first
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // Custom middleware should come after authentication
            //\App\Http\Middleware\RoleMiddleware::class,
            \App\Http\Middleware\UpdateLastVisit::class,
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
    // ->withMiddleware(function (Middleware $middleware) {
    //     $middleware->alias([
    //         'IsSuperAdmin' => SuperAdminMiddleware::class,
    //         'IsAdmin'=> AdminMiddleware::class,
    //         'IsUser'=> UserMiddleware::class,
    //         'web' => EncryptCookies::class,
    //         'start-session' => \Illuminate\Session\Middleware\StartSession::class,
    //     ]);
    // })
    // ->withExceptions(function (Exceptions $exceptions) {
    //     //
    // })->create();
