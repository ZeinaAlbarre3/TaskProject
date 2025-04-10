<?php

namespace App\Exceptions\Handlers;

use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ExceptionConfigHandler
{
    use ResponseTrait;

    public static function handle(\Throwable $e)
    {

        $ex = config('exceptions');

        foreach ($ex as $class => $value) {
            if ($e instanceof $class) {
                return self::Error([], $value['message'], $value['status']);
            }
        }
        return null;
    }
}
