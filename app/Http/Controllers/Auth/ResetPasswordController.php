<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserForgetPasswordRequest;
use App\Http\Requests\Auth\UserResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Services\Auth\PasswordResetService;
use App\Services\Email\EmailService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{

    use ResponseTrait;

    private PasswordResetService $passwordResetService;
    private EmailService $emailService;

    public function __construct(PasswordResetService $passwordResetService, EmailService $emailService){
        $this->passwordResetService = $passwordResetService;
        $this->emailService = $emailService;
    }

    public function resetLink(UserForgetPasswordRequest $request): JsonResponse
    {
        $data = $this->passwordResetService->resetLink($request->validated());

        [$user, $token] = $data['data'];

        $this->emailService->sendEmail($user,new ResetPasswordMail($token,$user['email']));

        return self::Success([],$data['message']);
    }

    public function resetPassword(UserResetPasswordRequest $request): JsonResponse
    {
        $data = $this->passwordResetService->resetPassword($request->validated());

        return self::Success($data['data'],$data['message']);
    }

}
