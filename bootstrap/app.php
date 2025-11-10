<?php

use App\Exceptions\InvalidTransactionException;
use App\Services\ResponseService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (InvalidTransactionException $e) {
            Log::channel('financial_emergency')->error($e->getMessage(), [
                'id' => $e->recordId,
            ]);
        });


        $exceptions->render(function (Throwable $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            $responseService = app(ResponseService::class);

            // Handle 4xx and 5xx HTTP exceptions
            if ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();
                $message = $e->getMessage() ?: Response::$statusTexts[$status] ?? 'HTTP Error';

                return $responseService->error($status, $message);
            }

            return $responseService->error(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'Something went wrong on the server. ' . $e->getMessage()
            );
        });
    })->create();
