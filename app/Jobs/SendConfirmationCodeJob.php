<?php

namespace App\Jobs;

use App\Mail\SendConfirmationCodeMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmationCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected User $user;
    protected int $confirmationCode;

    public function __construct(User $user, int $confirmationCode)
    {
        $this->user = $user;
        $this->confirmationCode = $confirmationCode;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new SendConfirmationCodeMail($this->confirmationCode));
    }
}
