<?php

namespace App\Http\Controllers\User;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SimpleUserController extends Controller
{
    public function showPosts()
    {
        $user = Auth::user();
        $posts = Post::with('images','user')->get();

        return view('user.user', compact('posts', 'user'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        $gender = Gender::cases();
        return view('user.profile', compact(['user', 'gender']));
    }

    public function applyPost(Request $request, Post $post): RedirectResponse
    {
        $cost= $request->input('tickets') * $post->price;
        Auth::user()->bookings()->attach($post->id, ['created_at' => now(), 'updated_at' => now(), 'cost' => $cost, 'tickets' => $request->input('tickets')]);

        return back()->with('success', 'Booking reserved');
    }

    public function cancelApplication(Post $post): RedirectResponse
    {
        Auth::user()->bookings()->detach($post->id);

        return back()->with('success', 'Canceled Application successfully');
    }
}
