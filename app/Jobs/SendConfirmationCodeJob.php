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
    protected string $email;
    protected int $confirmationCode;

    public function __construct(string $email, int $confirmationCode)
    {
        $this->email = $email;
        $this->confirmationCode = $confirmationCode;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Mail::to($this->email)->send(new SendConfirmationCodeMail($this->confirmationCode));
    }
}
