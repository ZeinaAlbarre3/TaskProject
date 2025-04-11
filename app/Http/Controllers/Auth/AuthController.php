<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Auth\Verification;
use App\Events\SendVerificationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Mail\SendCodeMail;
use App\Services\Auth\AuthService;
use App\Services\Auth\PasswordResetService;
use App\Services\Auth\TokenService;
use App\Services\Auth\VerificationService;
use App\Services\Email\EmailService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AuthController extends Controller
{

    use ResponseTrait;
    private AuthService $authService;
    private VerificationService $verificationService;
    private TokenService $tokenService;
    private EmailService $emailService;

    public function __construct(AuthService $authService,VerificationService  $verificationService,TokenService $tokenService,EmailService $emailService){
        $this->authService = $authService;
        $this->verificationService = $verificationService;
        $this->tokenService = $tokenService;
        $this->emailService = $emailService;
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $this->authService->createUser($request->validated());

        $code = $this->verificationService->generateCode($data['data'],'register',Verification::VERIFY_CODE->value);

    //    $this->emailService->sendEmail($data['data'],new SendCodeMail($code));

        return self::Success([
            'user' => $data['data'],
            'code' => $code,
        ], $data['message']);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());

        $code = $this->verificationService->generateCode($data['data'],'login',Verification::TWO_FA->value);

     //   $this->emailService->sendEmail($data['data'],new SendCodeMail($code));

        return self::Success([
            'user' => $data['data'],
            'code' => $code,
        ], $data['message']);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        $message = 'Logged out successfully';
        return self::Success('',$message);
    }
    public function refreshToken(Request $request): JsonResponse
    {
        $data = $this->tokenService->refreshToken($request);
        return self::Success( $data['data'],$data['message']);
    }



}
