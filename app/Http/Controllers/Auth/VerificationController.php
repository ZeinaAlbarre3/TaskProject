<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendVerificationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserCodeCheckRequest;
use App\Http\Requests\Auth\UserRefreshCodeRequest;
use App\Mail\SendCodeMail;
use App\Models\User;
use App\Services\Auth\TokenService;
use App\Services\Auth\VerificationService;
use App\Services\Email\EmailService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    use ResponseTrait;
    private VerificationService $verificationService;
    private TokenService $tokenService;
    private EmailService $emailService;

    public function __construct(VerificationService  $verificationService,TokenService $tokenService,EmailService $emailService){
        $this->verificationService = $verificationService;
        $this->tokenService = $tokenService;
        $this->emailService = $emailService;
    }

    public function verifyCode(UserCodeCheckRequest $request, $userId): JsonResponse
    {
        $data = $this->verificationService->verifyCode($request->validated(),$userId);

        $user = User::query()->findOrFail($userId);

        $tokens = $this->tokenService->generateTokens($user);

        return self::Success([
            'user' => $data['data'],
            'access_token' => $tokens['access_token']->plainTextToken,
            'refresh_token' => $tokens['refresh_token']->plainTextToken,
        ],$data['message']);
    }

    public function refreshCode(UserRefreshCodeRequest $request,$userId): JsonResponse
    {
        $data = $this->verificationService->refreshCode($request->validated(),$userId);

        [$user, $code] = $data['data'];

        $this->emailService->sendEmail($user,new SendCodeMail($code));

        return self::Success([
            'user' => $user,
            'code' => $code,
        ],$data['message']);
    }

}
