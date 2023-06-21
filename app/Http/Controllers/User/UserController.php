<?php

namespace App\Http\Controllers\User;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyPostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;


class UserController extends Controller
{
    public function showPosts()
    {
        $user = Auth::user();
        $posts = Post::with('images', 'user')
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orWhere(function ($query) {
                $query->where('start_date', '>', now());
            })
            ->orderByDesc('start_date')
            ->get();
        return view('user.user', compact('posts', 'user'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        $gender = Gender::cases();

        return view('user.profile', compact(['user', 'gender']));
    }

    public function showReservations()
    {
        $reservations = Auth::user()->bookings()->where('start_date','<', now())->get();
        return view('user.reservations', compact('reservations'));
    }

    public function applyPost(ApplyPostRequest $request, Post $post): RedirectResponse
    {
        $cost= $request->input('tickets.'.$post->id) * $post->price;

        try {
            Auth::user()->bookings()->attach($post->id, ['created_at' => now(), 'updated_at' => now(), 'cost' => $cost, 'tickets' => $request->input('tickets.'.$post->id)]);
            return back()->with('success', 'Booking reserved');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function modifyReservation(ApplyPostRequest $request, Post $post): ?RedirectResponse
    {
        $tickets = $request->input('tickets.'.$post->id);
        try {
            Auth::user()->bookings()->updateExistingPivot($post->id, [
                'tickets' => $tickets,
                'cost' => $tickets * $post->price,
                'updated_at' => now(),
            ]);
            return back()->with('success', 'Reservation updated successfully');
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
