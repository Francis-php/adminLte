<?php

namespace App\Traits;

use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;

trait UsersTableTrait
{

    public function renderUsers()
    {
        try {
            return DataTables::of($this->getModel())
                ->addColumn('action', function ($user) {
                    return view('admin.users.includes.action', ['user' => $user]);
                })
                ->toJson();
        } catch (Exception $e) {
            return back()->with('error', $e);
        }
    }

    public function getModel(): Collection
    {
        return User::with('role')->get()->map(function ($user){
            $user->type = $user->role->type;
            return $user;
        });
    }
}
