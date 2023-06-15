<?php

namespace App\Http\Controllers\User;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyPostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;


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

    public function applyPost(ApplyPostRequest $request, Post $post): RedirectResponse
    {
        $cost= $request->input('tickets') * $post->price;

        try {
            Auth::user()->bookings()->attach($post->id, ['created_at' => now(), 'updated_at' => now(), 'cost' => $cost, 'tickets' => $request->input('tickets')]);
            return back()->with('success', 'Booking reserved');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function cancelApplication(Post $post): RedirectResponse
    {
        try {
            Auth::user()->bookings()->detach($post->id);
            return back()->with('success', 'Canceled Application successfully');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }

    }
}
