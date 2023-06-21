<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;

class AdminPostController extends Controller
{

    public function read()
    {
        $posts = Post::with('images','user')
            ->orderByDesc('start_date')
            ->paginate(6);

        return view('admin.posts', compact('posts'));
    }

    public function showAgencies()
    {
        $agencies = User::agencies()
            ->with(['posts','posts.users'])
            ->withCount('posts')
            ->withSum('posts', 'price')
            ->get();
        $agencies->each(function ($agency) {
            $agency->totalEarnings = $agency->posts->sum(function ($post) {
                return $post->users->sum('pivot.cost');
            });
        });
        return view('admin.agencies', compact('agencies'));
    }

    public function showAgency($agencyId)
    {
        $agency = User::with(['posts','posts.users'])
            ->withCount('posts')
            ->withSum('posts', 'price')
            ->findOrFail($agencyId);
        $agency->totalEarnings = $agency->posts->sum(function ($post) {
            return $post->users->sum('pivot.cost');
        });
        return view('admin.agency', compact('agency'));
    }
}
