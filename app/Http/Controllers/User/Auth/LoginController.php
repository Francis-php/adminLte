<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(AuthenticateUserRequest $request): RedirectResponse
    {
        return Auth::attempt($request->validated())
            ?redirect()->route('home')
            :redirect()->back()->withInput()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
