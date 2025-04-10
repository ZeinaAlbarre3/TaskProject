<?php

namespace App\Exceptions\Handlers;

use App\Exceptions\Types\CustomException;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionCustomHandler
{
    use ResponseTrait;

    public static function handle(\Throwable $e){

        if ($e instanceof NotFoundHttpException && $e->getPrevious() instanceof ModelNotFoundException) {
            return self::Error([], 'User not found.', 404);
        }

        if ($e instanceof ValidationException) {
            return self::Validation([], $e->errors());
        }

        if ($e instanceof CustomException) {
            return self::Error([], $e->getMessage(), $e->getStatusCode());
        }

        return null;

    }
}
