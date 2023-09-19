<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $exception)
    {
       if ($exception instanceof QueryException){
            /* return response()->view('errors.database-connection', [], Response::HTTP_INTERNAL_SERVER_ERROR); */
            return response()->view('errors.database-connection', ['exception'=>$exception, 'request'=>$request], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
        /* elseif ($exception){
            return response()->view('errors.generic', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        } */
        return parent::render($request, $exception);
    }
}
