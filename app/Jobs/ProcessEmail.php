<?php

namespace App\Jobs;


use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $email;


    /**
     * Create a new job instance.
     */
    public function __construct(string $email)
    {
        $this->email= $email;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $passwordBroker= app(PasswordBroker::class);
        $passwordBroker->sendResetLink(['email' => $this->email]);
    }
}
