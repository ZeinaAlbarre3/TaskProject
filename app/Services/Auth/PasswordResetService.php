<?php

namespace App\Services\Auth;

use App\Enums\Auth\Verification;
use App\Exceptions\Types\CustomException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Pest\Support\Str;

class PasswordResetService
{
    /**
     * @throws CustomException
     */
    public function resetLink($request): array
    {
        $user = User::query()->where('email', $request['email'])->firstOrFail();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user['email']],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        return ['data' => [$user,$token], 'message' => 'Reset Link sent successfully', 'code' => 200];
    }

    /**
     * @throws CustomException
     */
    public function resetPassword($request): array
    {
        $data = DB::table('password_reset_tokens')
            ->where('token', $request['token'])
            ->where('email', $request['email'])
            ->first();

        if(!$data || $this->isTokenExpired($data->created_at)){
            DB::table('password_reset_tokens')->where('email', $request['email'])->delete();
            throw new CustomException("Invalid token or expired");
        }

        $user = User::query()->where('email', $request['email'])->firstOrFail();
        $user['password'] = $request['password'];
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request['email'])->delete();

        return ['data' => [], 'message' => 'Password reset successfully.', 'code' => 200];

    }
    private function isTokenExpired($createdAt): bool
    {
        $expireTime = Carbon::parse($createdAt)->addMinutes(Verification::RESET_PASSWORD->value);
        return $expireTime->isPast();
    }
}
