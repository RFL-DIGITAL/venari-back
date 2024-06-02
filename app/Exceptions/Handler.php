<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->stockResponse($e, 'Неправильный метод',$request,405);
        }
        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            return $this->stockResponse($e, 'Не найдено',$request,404);
        }
        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request,$e);
        }

        if (in_array($request->segment(1), ['api'])) {
            //
            $message = $e->getMessage();
            $status = 500;
            $headers = [];

            if ($e instanceof ValidationException) {
                $message = 'Неправильные аргументы.';
                foreach ($e->errors() as $error) {
                    $message .= ' ' . implode(' ', $error);
                }
                return $this->stockResponse($e, $message, $request, 400);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->stockResponse($e, 'Неправильный метод',$request,405);
            }
            if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                return $this->stockResponse($e, 'Не найдено',$request,404);
            }

            if ($e instanceof AuthenticationException) {
                return $this->unauthenticated($request,$e);
            }

            if ($e instanceof HttpException) {
                return $this->stockResponse($e, $e->getMessage(),$request,$e->getStatusCode())->withHeaders($e->getHeaders());
            }

            $response = response()->json([
                'status' => 'error',
                'message' => $message,
                'input' => $request->all(),
            ], $status);
            foreach ($headers as $header => $value) {
                $response->header($header,$value);
            }

            return $response;

        }


        return parent::render($request, $e);
    }


    protected function unauthenticated($request, $exception)
    {
        return response()->json([
                "error"=>"access_denied",
                "error_description"=>"The resource owner or authorization server denied the request."
        ],401);
    }


    public function stockResponse($e,$message,$request,$status = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'input' => $request->all(),
        ], $status);
    }


}
