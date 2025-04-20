<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\ImageController;
use App\Http\Controllers\User\PodcastController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::post('resetLink', 'resetLink')->name('reset.link');
        Route::post('resetPassword', 'resetPassword')->name('reset.password');
    });

    Route::controller(VerificationController::class)->group(function () {
        Route::post('verifyCode/{id}', 'verifyCode')->name('verify.code');
        Route::post('refreshCode/{userId}', 'refreshCode')->name('refresh.code');
    });

    Route::middleware(['auth:sanctum', 'scopes:refresh'])->controller(AuthController::class)->group(function () {
        Route::get('logout', 'logout')->name('logout');
        Route::get('refreshToken', 'refreshToken')->name('refresh.token');
    });
});

Route::middleware(['auth:sanctum', 'scopes:access-api'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(ImageController::class)->group(function () {
            Route::post('uploadImage', 'uploadImage')->name('upload.image');
            Route::post('uploadMultipleImages', 'uploadMultipleImages')->name('upload.multiple.image');
            Route::delete('deleteImage/{media}', 'deleteImage')->name('delete.image');
        });
        Route::controller(PodcastController::class)->group(function () {
            Route::post('uploadPodcast', 'uploadPodcast')->name('upload.podcast');
            Route::post('updatePodcast/{podcast}', 'updatePodcast')->name('update.podcast');
            Route::delete('deletePodcast/{podcast}', 'deletePodcast')->name('delete.podcast');
        });
        Route::controller(CommentController::class)->group(function () {
            Route::post('addComment', 'addComment')->name('add.comment');
            Route::get('getComments/{podcast}', 'getComments')->name('get.comment');
            Route::delete('deleteComment/{comment}', 'deleteComment')->name('delete.comment');
        });
    });
});
