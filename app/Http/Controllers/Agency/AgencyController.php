<?php

namespace App\Http\Controllers\Agency;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
    public function showCreator()
    {
        return view('agency.posts');
    }

    public function showProfile()
    {
        $user = Auth::user();
        $gender = Gender::cases();
        return view('agency.profile', compact('user', 'gender'));
    }

    public function editPost(Post $post)
    {
        return view('agency.editPost',compact('post'));
    }
}
