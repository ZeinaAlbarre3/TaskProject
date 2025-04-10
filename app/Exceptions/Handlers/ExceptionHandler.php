<?php

namespace App\Exceptions\Handlers;

use App\Exceptions\Types\CustomException;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionHandler
{
    use ResponseTrait ;

    public static function handle(\Throwable $e){

        if ($response = ExceptionCustomHandler::handle($e)) {
            return $response;
        }

        if ($response = ExceptionConfigHandler::handle($e)) {
            return $response;
        }

        return self::Error([],$e->getMessage() ?: 'Something went wrong.', 500);
    }
}
