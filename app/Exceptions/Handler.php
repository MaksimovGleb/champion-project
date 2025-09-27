<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
    {//универсальные ошибки
        if ($request->is('api/*') || $request->wantsJson()) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Модель не найдена',
                    'data'    => null,
                ], Response::HTTP_NOT_FOUND);
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибки проверки',
                    'data'    => $e->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ресурс не найден',
                    'data'    => 'Запрашиваемый ресурс не найден.',
                ], Response::HTTP_NOT_FOUND);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка аутентификации.',
                    'data'    => 'Пользователь не аутентифицирован.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($e instanceof QueryException) {
                if ($this->isForeignKeyConstraintViolation($e)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Нарушено ограничение целостности. Проверьте связанные данные.',
                        'data' => null,
                    ], Response::HTTP_BAD_REQUEST);
                }

                if ($this->isDefaultValueViolation($e)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка: одно из полей не имеет значения по умолчанию. Проверьте ваши данные.',
                        'data' => 'Поле обязательно для заполнения.',
                    ], Response::HTTP_BAD_REQUEST);
                }

                // Здесь можно добавить проверку на конкретный код ошибки или сообщение
                if (str_contains($e->getMessage(), "Field 'body' doesn't have a default value")) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка базы данных.',
                        'data' => 'Поле "body" обязательно для заполнения.',
                    ], Response::HTTP_BAD_REQUEST);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка',
                'data'    => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $e);
    }

    private function isForeignKeyConstraintViolation(QueryException $e): bool
    {
        // Код ошибки 23000 используется для нарушений целостности
        return $e->getCode() === '23000';
    }

    private function isDefaultValueViolation(QueryException $e): bool
    {
        // Код ошибки 1364 указывает на отсутствие значения по умолчанию
        return $e->getCode() === '1364'; //HY000
    }
}
