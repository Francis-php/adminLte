<?php

namespace App\Http\Controllers\Agency;

use App\Enums\Gender;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\AgencyService;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{

    public function showProfile()
    {
        $user = Auth::user();
        $gender = Gender::cases();
        return view('agency.profile', compact('user', 'gender'));
    }

    public function showAgencies()
    {
        $agencies = AgencyService::getAgencies();
        return view('admin.agencies', compact('agencies'));
    }


    public function showAgency($agencyId)
    {
       $agency = AgencyService::getAgency($agencyId);
        return view('admin.agency', compact('agency'));
    }
}
