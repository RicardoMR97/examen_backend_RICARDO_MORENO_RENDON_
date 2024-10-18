<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// Configuración de rutas
return Application::configure($app->basePath())
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Define tus middleware aquí
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Agregar manejadores de excepciones personalizados aquí
        $exceptions->renderable(function (Exception $e, $request) {
            // Aquí defines lo que quieres hacer con la excepción
            if ($e instanceof SomeCustomException) {
                return response()->json(['error' => 'Something went wrong!'], 500);
            }

            // Si la excepción no es una personalizada, delega el manejo al manejador global
            return null; // Retorna null para dejar que el manejador por defecto la maneje
        });
    })->create();
