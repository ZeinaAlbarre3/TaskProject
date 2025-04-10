<?php
namespace App\Services\Auth;

use App\Enums\Auth\TokenAbility;
use Illuminate\Support\Carbon;

class TokenService
{
    public function generateTokens($user): array
    {
        $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        $refreshToken = $user->createToken('refresh_token', ['refresh']);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }

    public function refreshToken($request): array
    {
        $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value],now()->addMinutes(config('sanctum.ac_expiration')));

        $request->user()->tokens()->where('name', 'refresh_token')->delete();

        return ['data' => $accessToken->plainTextToken, 'message' => 'Token generated successfully', 'code' => 200];
    }
}
