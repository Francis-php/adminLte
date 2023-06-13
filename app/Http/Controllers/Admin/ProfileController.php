<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditPasswordRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\ImageRequest;
use App\Jobs\ProcessEmailVerification;
use App\Models\User;
use App\Traits\PictureTrait;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use PictureTrait;

    public function showInfo()
    {
        $user = Auth::user();
        $gender = Gender::cases();

        return view('admin.profile', compact(['user','gender']));
    }

    public function updateInfo(EditProfileRequest $request, User $user): RedirectResponse
    {
        try {
            if($request->input('email') !== $user->email){
                $user->update([$request->validated(),$user->email_verified_at= null]);

                dispatch(new ProcessEmailVerification($user))->onQueue('database');
            }

            $user->update($request->validated());
            return back()->with('success', 'Information Updated');
        }catch(Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function updatePicture(ImageRequest $request, User $user): RedirectResponse
    {
        try {
            $this->uploadProfilePhoto($request->file('image'),$user);
            return back()->with('success', 'Profile Picture Updated');
        }catch(Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function deletePicture(User $user): ?RedirectResponse
    {
        try {
            $this->deleteProfilePhoto($user);
            return back()->with('success', 'Success');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function updatePass(EditPasswordRequest $request, User $user): RedirectResponse
    {
        try {
            $user->update(['password' => Hash::make($request->safe()->only(['password'])['password'])]);
            return back()->with('success', 'Success');
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
