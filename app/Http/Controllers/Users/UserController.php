<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\ImageRequest;
use App\Models\User;
use App\Traits\PictureTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    use PictureTrait;

    public function index()
    {
        return view('admin.users');
    }

    /**
     * @throws Exception
     */
    public function getUsers(): JsonResponse
    {
        $model = User::with('role')->get()->map(function ($user){
            $user->type = $user->role->type;
            return $user;
        });

        return DataTables::of($model)
            ->addColumn('action', function ($user){
                return view('action', ['user' => $user]);
            })
            ->toJson();
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
        return view('admin/users.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        return User::create($request->validated())
            ?redirect()->route('users.index')->with('success', 'User created successfully.')
            :redirect()->back()->with('error', 'Error occurred');
    }

    public function edit(User $user)
    {
        return view('admin/users.edit',compact('user'));
    }

    public function update(EditUserRequest $request, User $user): RedirectResponse
    {

        return $user->update($request->validated())
            ?redirect()->route('users.index')->with('success', 'User updated successfully')
            :redirect()->back()->with('error', 'Error occurred');

    }

    public function destroy(User $user): RedirectResponse
    {
        return $user->delete()
            ?redirect()->route('users.index')->with('success', 'User deleted successfully')
            :redirect()->back()->with('error', 'Error occurred');
    }
}
