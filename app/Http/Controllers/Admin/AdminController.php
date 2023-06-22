<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $gender = Gender::cases();

        return view('admin.profile', compact(['user','gender']));
    }
}
