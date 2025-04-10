<?php

namespace App\Services\Auth;

use App\Enums\Auth\Verification;
use App\Exceptions\Types\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class VerificationService
{
    public function generateCode(User $user,$type,$value): int
    {
        $cacheKey = 'user_code_' . $user['id'];
        $code = mt_rand(100000, 999999);

        Cache::put($cacheKey, [
            'code' => $code,
            'type' => $type,
        ],now()->addMinutes($value));

        return $code;
    }

    /**
     * @throws CustomException
     */

    public function verifyCode($request, $userId): array
    {
        $user=User::query()->findOrFail($userId);
        $cacheKey = 'user_code_' . $userId;
        $data = Cache::get($cacheKey);

        if (!$data) {
            throw new CustomException('Your code has expired.',422);
        }

        if ($data['code'] != $request['code']) {
            throw new CustomException('Wrong code.',422);
        }

        if ($data['type'] !== $request['type']) {
            throw new CustomException('Invalid code type.',422);
        }

        Cache::forget($cacheKey);

        return ['data' => $user, 'message' => 'The code is correct. You have successfully verified.', 'code' => 200];
    }


    public function refreshCode($request, $userId): array
    {
        $cacheKey = 'user_code_' . $userId;

        Cache::forget($cacheKey);

        $value = match ($request['type']) {
            'login' => Verification::TWO_FA->value,
            'register' => Verification::VERIFY_CODE->value,
        };

        $user = User::query()->findOrFail($userId);

        $code = $this->generateCode($user, $request['type'], $value);

        return ['data' => [$user, $code], 'message' => 'Code refreshed successfully.', 'code' => 200];
    }
}
