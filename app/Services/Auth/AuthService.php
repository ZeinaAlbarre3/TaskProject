<?php

namespace App\Services\Auth;

use App\Exceptions\Types\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function createUser(array $request): array
    {
        $user = User::query()->create($request);
        return ['data' => $user, 'message' => 'User created successfully', 'code' => 200];
    }

    /**
     * @throws CustomException
     */
    public function login($request): array
    {
        $user = User::query()->where('email',$request['email'])->firstOrFail();
        if (!Hash::check($request['password'], $user->password)) {
            throw new CustomException('Incorrect email or password.', 400);
        }
        return ['data' => $user, 'message' => 'Verification code sent, please verify.','code' => 200];
    }

}
