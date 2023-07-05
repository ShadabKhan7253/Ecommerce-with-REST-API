<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof ValidationValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if($e instanceof AuthenticationException) {
            return $this->unauthenticated($request,$e);
        }

        if($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(),403);
        }

        if($e instanceof NotFoundHttpException) {
            return $this->errorResponse("The specified URL cannot be found",404);
        }

        if($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("The specified method is invalid for this request",405);
        }

        if($e instanceof ModelNotFoundException) {
            $modelName = class_basename($e->getModel());
            return $this->errorResponse("$modelName does not exist with the specified key",404);
        }

        if($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(),$e->getStatusCode());
        }
        return parent::render($request,$e);

    }

    protected function convertValidationExceptionToResponse(ValidationValidationException $e, $request)
    {
        $this->errorResponse($e->getMessage(),422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse("Unauthenticated",401);
    }
}
