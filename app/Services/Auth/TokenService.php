<?php
namespace App\Services\Auth;

class TokenService
{
    public function generateTokens($user): array
    {
        $accessToken = createAccessToken($user);
        $refreshToken = createRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }

    public function refreshToken($request): array
    {
        $request->user()->tokens()->where('name', 'access_token')->delete();

        $accessToken = createAccessToken($request->user());

        return ['data' => $accessToken->plainTextToken,'message' => 'Token refreshed successfully','code' => 200,];
    }
}
