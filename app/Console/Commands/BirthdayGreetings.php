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

        $toEmail = 'kaldarbekovazimbek@yandex.ru';
        $subject = 'Birthday greetings';
        $message = 'Happy birthday!';

        Mail::raw($message, function ($message) use ($toEmail, $subject) {
            $message->to($toEmail)->subject($subject);
        });

        $this->info('Birthday greetings sent successfully.');

//        return CommandAlias::SUCCESS;
    }

}
