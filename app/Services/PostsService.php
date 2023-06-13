<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PostsService
{
    public static function storePost($request): void
    {
        $user = Auth::user();
        $post = $user->posts()->create($request->only('title', 'description'));
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
}
