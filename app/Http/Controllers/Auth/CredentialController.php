<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\ProcessEmail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CredentialController extends Controller
{
    public function show()
    {
        return view('auth.passwords.email');
    }

    public function sendMail(EmailRequest $request): RedirectResponse
    {
        $validated= $request-> validated();

        ProcessEmail::dispatch($validated['email'])->onQueue('email');

        return redirect()->back()->with(['status' => 'A reset link is sent at your email']);

    }

    public function showResetForm(EmailRequest $request ,string $token)
    {
        $validated= $request-> validated();
        $email=$validated['email'];
        return view('auth.passwords.reset',['token'=> $token,'email'=> $email]);
    }

    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $validated=$request->validated();

        $status = Password::reset(
            $validated->only('email','password','password_confirmation','token'),
            function (User $user, string $password){
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ?redirect()->route('login')->with('status',__($status))
            : back()->withErrors(['email'=>[__($status)]]);
    }

}
