<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Garante que SASHA.Assuncao@hydro.com sempre caia no grupo admin
            if (isset($_SERVER['HTTP_COOKIE']) && strpos($_SERVER['HTTP_COOKIE'], 'laravel_session') !== false) {
                try {
                    $sessionId = null;
                    if (preg_match('/laravel_session=([^;]+)/', $_SERVER['HTTP_COOKIE'], $matches)) {
                        $sessionId = $matches[1];
                    }
                    if ($sessionId) {
                        $sessionPath = sys_get_temp_dir().'/sessions/'.$sessionId;
                        if (file_exists($sessionPath)) {
                            $sessionData = file_get_contents($sessionPath);
                            if (strpos($sessionData, 'SASHA.Assuncao@hydro.com') !== false) {
                                Route::middleware(['web', 'route_admin'])->group(base_path('routes/admin.php'));
                                return;
                            }
                        }
                    }
                } catch (Exception $e) {}
            }
            Route::middleware(['web', 'route_admin'])->group(base_path('routes/admin.php'));
            Route::middleware(['web', 'route_client'])->group(base_path('routes/client.php'));
            Route::middleware(['web', 'route_contractor'])->group(base_path('routes/contractor.php'));
            Route::middleware(['web', ''])->group(function () {
                Route::get('/contratos');
                Route::get('/evidencias');
            });
        },

    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdmin::class,
            'client' => \App\Http\Middleware\CheckClient::class,
            'route_admin' => \App\Http\Middleware\RouteAdmin::class,
            'route_client' => \App\Http\Middleware\RouteClient::class,
            'route_contractor' => \App\Http\Middleware\RouteContractor::class,
            'contract_default' => \App\Http\Middleware\CheckDefaultContract::class,
            'sasha' => \App\Http\Middleware\SashaMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

