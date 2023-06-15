<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class AdminPostController extends Controller
{

    public function read()
    {
        $posts = Post::with('images')->get();

        return view('admin.posts', compact('posts'));
    }
}
