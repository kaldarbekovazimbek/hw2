<?php

namespace App\Http\Controllers;

use App\Mail\BirthdayGreetingsMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        $users = User::query()->whereMonth('birthday', now()->month)
            ->whereDay('birthday', now()->day)
            ->get();
        foreach ($users as $user) {

            Mail::to($user->email)->send(new BirthdayGreetingsMail($user->name));
        };
        dd('ok');
    }
}
