<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\ProcessEmailVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    use Notifiable;

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());
        Auth::attempt($request->validated());

        event(new Registered($user));
        return redirect()->route('home')->with('success', 'Registration successful! Please check your email for verification.');
    }

    public function show()
    {
        return view('auth.verify');
    }

    public function verify(EmailVerificationRequest $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if($request->hasValidSignature()){
            if(!$user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
                Auth::login($user);
                event((new Verified($user)));
            }
            return redirect()->route('user.show')->with('success', 'Email verified successfully.');
        }

        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }

    public function resend(Request $request): RedirectResponse
    {
        if($request->user()->hasVerifiedEmail()){
            return redirect()->route('home');
        }

        $user = $request->user();
        dispatch(new ProcessEmailVerification($user))->onQueue('database');
        return back()->with('success', 'A new verification link has been sent to your email address.');
    }
}
