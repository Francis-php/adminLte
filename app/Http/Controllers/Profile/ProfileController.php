<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPasswordRequest;
use App\Http\Requests\EditProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function showInfo()
    {
        $user=Auth::user();
        return view('admin.profile',compact('user'));
    }
    public function updateInfo(EditProfileRequest $request, User $user): RedirectResponse
    {
        $validated=$request->validated();
        $image = $request->file('image');

        if ($image) {
            if ($user->image) {
                Storage::delete('public/images/' . $user->image);}
            $fileName = $image->getClientOriginalName();
            $destinationPath = public_path().'/images';
            $image->move($destinationPath, $fileName);
        } else {
            $fileName = $user->image;
        }
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'image' => $fileName,
        ]);
        return redirect()->route('profile')
            ->with('success','Information Updated');
    }

    public function updatePass(EditPasswordRequest $request): RedirectResponse
    {
        $validated=$request->safe()->only(['password']);
        Auth::user()->update([
            'password' =>
                Hash::make($validated['password']),
        ]);
        return redirect()->route('password')
            ->with('success','Information Updated');
    }

}
