<?php

namespace App\Console\Commands;

use App\Models\Post;
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
    public function handle(): void
    {
        $upcomingBookings = Post::tomorrowTrips()->get();
        foreach ($upcomingBookings as $booking) {
            foreach ($booking->users as $user) {
                $user->notify(new BookingReminderNotification($booking));
            }
        }
        $this->info('Booking notifications sent successfully!');
    }
}
