<?php

use App\Enums\Auth\TokenAbility;
use Illuminate\Support\Carbon;

function createAccessToken($user)
{
    return $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));

}

function createRefreshToken($user)
{
    return $user->createToken('refresh_token', ['refresh'],Carbon::now()->addMinutes(config('sanctum.rt_expiration')));
}
