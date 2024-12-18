<?php

use App\Http\Middleware\AlwaysAcceptJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v4')
                ->group(base_path('routes/api_v4.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        //$middleware->withThrottleApi('products');
        $middleware->prependToGroup('api', AlwaysAcceptJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Object Not Found'], 404);
            }
        });

        $exceptions->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Method Not Allowed'], 405);
            }
        });

        $exceptions->renderable(function (ValidationException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
            }
        });
    })->create();



