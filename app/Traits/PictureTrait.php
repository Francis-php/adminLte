<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait PictureTrait
{
    public function uploadProfilePhoto($image,$user): void
    {

        $hashedName = $image->hashName();
        $path = '/storage/images/profile/' . $hashedName;

        $previousImage = $user->images()->where('path', 'LIKE', '/storage/images/profile/%')->first();

        if($previousImage){
            Storage::disk('public')->delete('images/profile/' . $previousImage->hash_name);

            $previousImage->update([
                'path' => $path,
                'hash_name' => $hashedName,
                'original_name' => $image->getClientOriginalName(),
                'extension' => $image->getClientOriginalExtension(),
                'size' => $image->getSize(),
            ]);
        }else{
            $user->images()->create([
                'path' => $path,
                'hash_name' => $hashedName,
                'original_name' => $image->getClientOriginalName(),
                'extension' => $image->getClientOriginalExtension(),
                'size' => $image->getSize(),
            ]);
        }

        $image->storeAs('public/images/profile', $hashedName);

    }
    public function deleteProfilePhoto($user): void
    {
        $image=$user->images()->where('path', 'LIKE', '/storage/images/profile/%')->first();

        Storage::disk('public')->delete('images/profile/' . $image->hash_name);
        $image->delete();
    }

}
