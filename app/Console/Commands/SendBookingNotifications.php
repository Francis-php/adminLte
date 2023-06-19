<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\BookingReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBookingNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-booking-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send booking notifications to users one day before their booking starts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->addDay();
        $users = User::with('upcomingBookings')->get();
        foreach ($users as $user) {
            foreach ($user->upcomingBookings as $booking) {
                $user->notify(new BookingReminderNotification($booking));
            }
        }
        $this->info('Booking notifications sent successfully!');
    }
}
