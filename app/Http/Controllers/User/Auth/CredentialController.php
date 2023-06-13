<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\ProcessEmail;
use App\Services\PasswordResetService;
use Exception;
use Illuminate\Http\RedirectResponse;

class CredentialController extends Controller
{

    public function show()
    {
        return view('auth.passwords.email');
    }

    public function sendMail(EmailRequest $request): RedirectResponse
    {
        ProcessEmail::dispatch($request-> validated()['email'])->onQueue('database');

        return redirect()->back()->with(['status' => 'A reset link is sent at your email']);
    }

    public function showResetForm(EmailRequest $request ,string $token)
    {
        return view('auth.passwords.reset',['token' => $token, 'email' => $request->validated()['email']]);
    }

    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        try {
            PasswordResetService::resetPassword($request->validated());
            return redirect()->route('login')->with('status', 'Password Updated');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
