<?php

namespace App\Console\Commands;

use App\Mail\BirthdayGreetingsMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class BirthdayGreetingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:birthday-greetings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday greetings to users';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $users = User::query()->whereMonth('birthday', now()->month)
            ->whereDay('birthday', now()->day)
            ->get();

        foreach ($users as $user) {

            Mail::to($user->email)->send(new BirthdayGreetingsMail($user->name));
        }

        $this->info('Birthday greetings sent successfully.');

    }
}
