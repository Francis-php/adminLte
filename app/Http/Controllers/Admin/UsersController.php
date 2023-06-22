<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UsersService;
use App\Traits\PictureTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class UsersController extends Controller
{
    use PictureTrait;

    public function read()
    {
        return view('admin.users');
    }

    public function getUsers(): JsonResponse
    {
        return (new UsersService)->renderUsers();
    }

    public function updatePicture(ImageRequest $request, User $user): RedirectResponse
    {
        try {
            $this->uploadProfilePhoto($request->file('image'), $user);
            return back()->with('success', 'Profile Picture Updated');
        }catch (Exception $exception) {
            return back()->with('error', $exception);
        }
    }

    public function create()
    {
        $gender = Gender::cases();
        $roles = Role::all();

        return view('admin/users.create', compact(['gender', 'roles']));
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        try {
            User::create($request->validated());
            return redirect()->route('users.read')->with('success', 'User created successfully');
        }catch (Exception $exception){
            return back()->with('error', $exception);
        }
    }

    public function edit(User $user)
    {
        $gender = Gender::cases();
        return view('admin/users.edit',compact(['user', 'gender']));
    }

    public function update(EditUserRequest $request, User $user): RedirectResponse
    {
        try {
            $user->update($request->validated());
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }catch (Exception $exception){
            return back()->with('error', $exception);
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
            return redirect()->route('users.read')->with('success', 'User deleted successfully');
        }catch (Exception $exception){
            return back()->with('error', $exception);
        }
    }
}
