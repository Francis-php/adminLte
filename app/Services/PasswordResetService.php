<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetService
{
    public static function resetPassword($validated): string
    {
        Password::reset(
            $validated, function (User $user, string $password){
            $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });
        return Password::PASSWORD_RESET;
    }
}
