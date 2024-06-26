<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\PostsRequest;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use App\Services\PostsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function getAllPosts(Request $request)
    {
        $posts = PostsService::getAllPosts($request);
        $agencies = User::agencies()->get();
        return view('admin.posts', compact('posts', 'agencies', 'request'));
    }
    public function create()
    {
        return view('agency.posts');
    }

    public function read()
    {
        $posts =  Auth::user()->posts()->with('images')->get()->sortByDesc('start_date');
        return view('agency.mainPage', compact('posts'));
    }

    public function showPost(Post $post)
    {
        return view('agency.editPost',compact('post'));
    }

    public function update(PostsRequest $request, Post $post): RedirectResponse
    {
        try {
            $post->update($request->all());
            return back()->with('success', 'Post Updated');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete(Post $post): RedirectResponse
    {
        try {
            $post->images()->delete();
            Storage::disk('public')->deleteDirectory('images/'.$post->user->id.'/post/' .$post->id);
            $post->delete();
            return back()->with('success', 'Post deleted !');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function deleteImage(Media $image): RedirectResponse
    {
        try {
            Storage::disk('public')->delete('images/'.$image->user_id.'/post/'.$image->post_id.'/'.$image->hash_name);
            $image->delete();
            return back()->with('success', 'Image deleted!');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }

    }

    public function store(PostsRequest $request): ?RedirectResponse
    {
        try{
            PostsService::storePost($request);
            return redirect()->route('agency.main_page')->with('success', 'New Post Created');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function addPostImage(ImageRequest $request, Post $post): RedirectResponse
    {
        try {
            PostsService::addImage($request->validated(), $post);
            return back()->with('success', 'Image added successfully');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function showApplications(Post $post)
    {
        $users = $post->users;
        return view('agency.applications', compact('post', 'users'));
    }


    public function deleteApplication(User $user, Post $post): ?RedirectResponse
    {
        try {
            $user->bookings()->detach($post->id);
            return back()->with('success', 'Reservation deleted successfully');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }


}
