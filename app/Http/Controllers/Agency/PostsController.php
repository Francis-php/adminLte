<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\PostsRequest;
use App\Models\Booking;
use App\Models\Media;
use App\Models\Post;
use App\Services\PostsService;
use App\Services\RenderPostsTableService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PostsController extends Controller
{

    public function create()
    {
        return view('agency.posts');
    }

    public function read()
    {
        $posts =  Auth::user()->posts()->with('images')->get();
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

    public function showApplications()
    {
        return view('agency.applications');
    }

    public function getApplicationData(): JsonResponse
    {
        $bookings = Booking::with('post', 'user')->get();
        return (new RenderPostsTableService())->renderPosts($bookings);
    }

    public function deleteApplication(Booking $booking): ?RedirectResponse
    {
        try {
            $booking->delete();
            return back()->with('success', 'Reservation deleted successfully');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
