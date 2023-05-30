<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{

    public function index()
    {
        return view('admin.users');
    }

    /**
     * @throws Exception
     */
    public function getUsers(): JsonResponse
    {
        $model = User::with('role')->get();
        $model = $model->map(function ($user) {
            $user->type = $user->role->type;
            return $user;
        });

        return DataTables::of($model)
            ->addColumn('action', function ($user) {
                return "<div><form action='" . route('users.destroy', $user->id) . "' method='POST'><a class='btn btn-primary' href='" . route('users.edit', $user->id) . "'>Edit</a>
" . csrf_field() . " " . method_field('DELETE') . "<button type='submit' class='btn btn-danger'>Delete</button></form></div>";
            })

            ->toJson();

    }
    public function create()
    {
        return view('admin/users.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        $validated=$request->validated();
        User::create($validated);
        return redirect()->route('users.index')
            ->with('success','User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin/users.edit',compact('user'));
    }

    public function update(EditUserRequest $request, User $user): RedirectResponse
    {
        $validated=$request->validated();
        $image = $request->file('image');

        if ($image) {
            $fileName = $image->getClientOriginalName();
            $destinationPath = public_path().'/images';
            $image->move($destinationPath, $fileName);
        } else {
            $fileName = $user->image; // Use the existing image if no new image is uploaded
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'image'=> $fileName ,
        ]);
        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {

        $user->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
}
