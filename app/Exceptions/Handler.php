<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // return parent::render($request, $exception);
        $response = $this->handleException($request, $exception);

        return $response;
    }

    public function handleException($request, Exception $exception)
    {
        $errResponse = [];

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));

            $errResponse['message'] = "Does not exists any {$modelName} with the specified identificator";
            return $this->errorResponse($errResponse, 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            $errResponse['message'] = $exception->getMessage();
            return $this->errorResponse($errResponse, 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            $errResponse['message'] = 'The specified URL cannot be found';
            return $this->errorResponse($errResponse, 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $errResponse['message'] = 'The specified method for the request is invalid';
            return $this->errorResponse($errResponse, 405);
        }

        if ($exception instanceof HttpException) {
            $errResponse['message'] = $exception->getMessage();
            return $this->errorResponse($errResponse, $exception->getStatusCode());
        }

        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];

            if ($errorCode == 1451) {
                $errResponse['message'] = 'Cannot remove this resource permanently. It is related with any other resource';
                return $this->errorResponse($errResponse, 409);
            }
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        $errResponse['message'] = 'Unexpected Exception. Try later';
        return $this->errorResponse($errResponse, 500);
        // return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        $errResponse = [];
        $errResponse['message'] = 'Validation error';
        $errResponse['data'] = $errors;
        return $this->errorResponse($errResponse, 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $errResponse = [];
        $errResponse['message'] = $exception->getMessage() ?: 'Unauthenticated';
        return $this->errorResponse($errResponse, 401);
    }
}
