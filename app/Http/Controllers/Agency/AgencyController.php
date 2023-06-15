<?php

namespace App\Http\Controllers\Agency;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{

    public function show()
    {
        $user = Auth::user();
        $gender = Gender::cases();
        return view('agency.profile', compact('user', 'gender'));
    }
}
