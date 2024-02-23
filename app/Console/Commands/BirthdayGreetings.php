<?php

namespace App\Console\Commands;

use App\Mail\BirthdayGreeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Command\Command as CommandAlias;

class BirthdayGreetings extends Command
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

        $users = User::query()->whereMonth('birthday', now()->month)->whereDay('birthday', now()->day)->get();

        foreach ($users as $user){
            $email = $user->email;
            $name = $user->name;
        }

        /**
         * @var string $name
         */
        $message = "Happy birthday {$name}!";

        /**
         * @var string $email
         */
        Mail::raw($message, function ($message) use ($email, $name) {
            $message->to($email, $name)->subject('Birthday greetings');
        });


        $this->info('Birthday greetings sent successfully.');

    }

}
