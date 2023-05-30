<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $latestHour = Carbon::now()->subHour();
        $users=User::count();
        $newUsers = User::where('created_at', '>', $latestHour)->count();
        $role=Role::find(2);
        $admins= $role->users->count();
//        $start_time = session('start_time');
//        $duration = $start_time->diff(Carbon::now());
//        $hours = $duration->h;
//        $minutes = $duration->i;
//        $seconds = $duration->s;

        return view('admin.home',[
            'users' => $users,
            'newUsers' => $newUsers,
            'admins' => $admins,
//            'hours' => $hours,
//            'minutes' => $minutes,
//            'seconds' => $seconds,
        ]);
    }

}
