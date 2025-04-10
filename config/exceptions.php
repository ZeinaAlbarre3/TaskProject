<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Exception\RfcComplianceException;

return [

    ModelNotFoundException::class => [
        'message' => 'User not found.',
        'status' => 404,
    ],

    NotFoundHttpException::class => [
        'message' => 'Route not found.',
        'status' => 404,
    ],

    AuthenticationException::class => [
        'message' => 'Unauthenticated.',
        'status' => 401,
    ],

    QueryException::class => [
        'message' => 'A database error occurred.',
        'status' => 500,
    ],

    PostTooLargeException::class => [
        'message' => 'Uploaded data is too large.',
        'status' => 413,
    ],

    MethodNotAllowedHttpException::class => [
        'message' => 'HTTP method not allowed.',
        'status' => 405,
    ],

    TooManyRequestsHttpException::class => [
        'message' => 'Too many requests.',
        'status' => 429,
    ],

    AuthorizationException::class => [
        'message' => 'You are not authorized to access this resource.',
        'status' => 403,
    ],

    TransportException::class => [
        'message' => 'Email server is currently unreachable.',
        'status' => 502,
    ],

    TransportExceptionInterface::class => [
        'message' => 'Failed to send email. Please try again.',
        'status' => 502,
    ],

    RfcComplianceException::class => [
        'message' => 'Invalid email format.',
        'status' => 422,
    ],

];
