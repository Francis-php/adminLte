<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpleUserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('user.user',compact('user'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
}
