<?php

namespace App\Http\Controllers;

use App\Exceptions\BadCredentialsException;
use App\Exceptions\ExistsObjectException;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Mail\SendConfirmationCodeMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthUserController extends Controller
{


    /**
     * @throws ExistsObjectException
     */
    public function register(UserRequest $request): JsonResponse
    {

        $user = User::query()->where('email', $request->email)->first();

        if ($user !== null) {
            throw new ExistsObjectException('User already exists', 409);
        }

        $validData = $request->validated();

        $user = User::query()->create($validData);

        $confirmationCode = rand(10000, 99999);

        Cache::put('confirmation_code_' . $user->email, $confirmationCode, now()->addMinute(10));

//        SendConfirmationCodeJob::dispatch($user, $confirmationCode);
        Mail::to($user->email)->send(new SendConfirmationCodeMail($confirmationCode));
        return \response()->json([
            'message'=>'Code send to user mail',
        ]);
    }

    public function confirmationEmail(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $confirmationCode = $request->input('confirmation_code');

        $cachedConfirmationCode = Cache::get('confirmation_code_' . $email);
        if ($cachedConfirmationCode != $confirmationCode) {
            return \response()->json([
                'message' => 'Invalid confirmation code'
            ], 403);
        }

        Cache::forget('confirmation_code' . $email);
        $user = User::query()->where('email', $email)->first();
        $user['email_verified_at'] = now();
        $user->save();
        return response()->json([
            'message' => 'Email verified',
        ]);
    }

    /**
     * @throws BadCredentialsException
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        /**
         * @var User $user
         */

        $validatedData = $request->validated();

        $user = User::query()->where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            throw new BadCredentialsException(__('messages.bad_credentials'));
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(): JsonResponse
    {

        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }

}
