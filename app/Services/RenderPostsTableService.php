<?php

namespace App\Services;

use App\Models\Booking;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\DataTables;

class RenderPostsTableService
{

    public function renderPosts($bookings): JsonResponse|RedirectResponse
    {
        try {
            return DataTables::of($bookings)
                ->with(['post', 'user'])
                ->addColumn('user', function ($booking) {
                    return $booking->user->name;
                })
                ->addColumn('post_title', function ($booking) {
                    return $booking->post->title;
                })
                ->addColumn('start_date', function ($booking) {
                    return $booking->post->start_date;
                })
                ->addColumn('end_date', function ($booking) {
                    return $booking->post->end_date;
                })
                ->addColumn('action', function ($booking) {
                    return '<a class="btn btn-danger" href="#" onclick="document.getElementById(\'cancel-form-' . $booking->id . '\').submit();">Cancel</a>
            <form id="cancel-form-' . $booking->id . '" action="' . route('delete-application',$booking->id) . '" method="POST" style="display: none;">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE">
            </form>';
                })
                ->toJson();
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
