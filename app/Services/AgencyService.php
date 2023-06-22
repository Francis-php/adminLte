<?php

namespace App\Services;

use App\Models\User;

class AgencyService
{

    public static function getAgencies()
    {
        $agencies = User::agencies()
            ->with(['posts','posts.users'])
            ->withCount('posts')
            ->withSum('posts', 'price')
            ->get();
        $agencies->each(function ($agency) {
            $agency->totalEarnings = $agency->posts->sum(function ($post) {
                return $post->users->sum('pivot.cost');
            });
        });
        return $agencies;
    }

    public static function getAgency($agencyId)
    {
        $agency = User::with(['posts','posts.users'])
            ->withCount('posts')
            ->withSum('posts', 'price')
            ->findOrFail($agencyId);
        $agency->totalEarnings = $agency->posts->sum(function ($post) {
            return $post->users->sum('pivot.cost');
        });
        return $agency;
    }
}
