<?php

namespace App\Listeners;

use App\Jobs\ProcessEmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendVerificationEmailListener
{
    /**
     * Create the event listener.
     */


    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            dispatch(new ProcessEmailVerification($event->user))->onQueue('database');
        }
    }
}
