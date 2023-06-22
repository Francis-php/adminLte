<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use LaravelIdea\Helper\App\Models\_IH_Post_C;

class PostsService
{
    public static function storePost($request): void
    {
        $user = Auth::user();
        $post = $user->posts()->create($request->only('title', 'description','price', 'start_date', 'end_date', 'tickets'));
        $images = $request->file('images');

        if($images){
            foreach($images as $image){
                $hashedName = $image->hashName();
                $path = '/storage/images/'.$user->id.'/post/'.$post->id.'/'.$hashedName;

                $imageData = [
                    'path' => $path,
                    'hash_name' => $hashedName,
                    'original_name' => $image->getClientOriginalName(),
                    'extension' => $image->getClientOriginalExtension(),
                    'size' => $image->getSize(),
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ];
                $user->posts->find($post->id)->images()->create($imageData);
                $image->storeAs('public/images/'.$user->id.'/post/'.$post->id, $hashedName);
            }
        }
    }
    public static function addImage($validated, $post): void
    {
        $image = $validated['image'];
        $hashedName = $image->hashName();

        $imageData=[
            'path' => '/storage/images/'.$post->user->id.'/post/'.$post->id.'/' . $hashedName,
            'hash_name' => $hashedName,
            'original_name' => $image->getClientOriginalName(),
            'extension' => $image->getClientOriginalExtension(),
            'size' => $image->getSize(),
            'user_id' => $post->user->id,
        ];

        $post->images()->create($imageData);
        $image->storeAs('public/images/'.$post->user->id.'/post/'.$post->id, $hashedName);
    }

    public static function getAllPosts($request): array|LengthAwarePaginator|_IH_Post_C|\Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Post::with('images', 'user');

        if ($request->filled('title')) {
            $query->where('title', 'LIKE', '%' . $request->input('title') . '%');
        }

        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->input('end_date'));
        }
        if ($request->filled('status')){
            if ($request->input('status') === 'active'){
                $query->whereDate('start_date', '>=', now());
            }elseif ($request->input('status') === 'completed') {
                $query->whereDate('start_date', '<', now());
            }
        }

        if ($request->filled('agency')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->input('agency'));
            });
        }
        if ($request->filled('sort_by')) {
            $sortField = $request->input('sort_by');

            switch ($sortField) {
                case 'name_asc':
                    $query->join('users', 'posts.user_id', '=', 'users.id')
                        ->orderBy('users.first_name');
                    break;
                case 'name_desc':
                    $query->join('users', 'posts.user_id', '=', 'users.id')
                        ->orderByDesc('users.first_name');
                    break;
                case 'start_date_asc':
                    $query->orderBy('start_date',);
                    break;
                case 'start_date_desc':
                    $query->orderByDesc('start_date');
                    break;
                default:
                    break;
            }
        }
       return $query->paginate(6);
    }

    public static function getApplicablePosts()
    {
        $user = Auth::user();
        return Post::with('images', 'user')
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orWhere(function ($query) {
                $query->where('start_date', '>', now());
            })
            ->orderByDesc('start_date')
            ->get();
    }
}
