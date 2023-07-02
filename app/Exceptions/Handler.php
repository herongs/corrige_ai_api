<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
  use ApiResponser;

  /**
   * A list of the exception types that are not reported.
   *
   * @var array<int, class-string<Throwable>>
   */
  protected $dontReport = [
    //
  ];

  /**
   * A list of the inputs that are never flashed for validation exceptions.
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

    $this->renderable(function (Exception $exception, $request) {
      $request->headers->set('Accept', 'application/json');

      if ($exception instanceof MethodNotAllowedHttpException) {
        return $this->errorResponse('Método inválido!', 405);
      }

      if ($exception instanceof ModelNotFoundException) {
        return $this->errorResponse("Informação não pode ser encontrada!", 404);
      }

      if ($exception instanceof NotFoundHttpException) {
        return $this->errorResponse("Informação não pode ser encontrada!", 404);
      }

      if ($exception instanceof HttpException) {
        return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
      }

      if ($exception instanceof ValidationException) {
        return $this->errorResponse($exception->getMessage(), 422, $exception->errors());
      }

      if ($exception instanceof QueryException) {
        return $this->errorResponse($exception->getMessage(), 409);
      }

      return $this->errorResponse('Erro no servidor, tente mais tarde!', 500);
    });

    $this->reportable(function (Throwable $e) {
      //
    });
  }
}
