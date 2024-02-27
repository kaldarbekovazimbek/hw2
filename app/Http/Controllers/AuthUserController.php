<?php

namespace App\Http\Controllers;

use App\DTO\UsersDTO;
use App\Exceptions\BadCredentialsException;
use App\Exceptions\DuplicateException;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\User\CreateUserService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{

    public function __construct(private CreateUserService $createUserService,)
    {
    }

    /**
     * @throws DuplicateException
     */
    public function register(UserRequest $request): JsonResponse
    {
        /**
         * @var User $validatedData
         */
        $validatedData = $request->validated();

        $user = $this->createUserService->createUser(UsersDTO::fromArray($validatedData));
//
//        $user = User::query()->where('email', $validatedData['email']);
//        if ($user === null){
//            throw new DuplicateException(__('messages.object_with_email_exists'), 409);
//        }

        $token = $user->createToken('app-token')->plainTextToken;
        return response()->json([
            'token'=>$token
        ]);
    }

    /**
     * @throws BadCredentialsException
     */
    public function login(UserLoginRequest $request)
    {
        /**
         * @var User $user
         */
        $validatedData = $request->validated();

        $user = User::query()->where('email', $validatedData->email)->first();

        if (!$user || !Hash::check($validatedData->password, $user->password)) {
            throw new BadCredentialsException(__('messages.bad_credentials'));
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token'=>$token
        ]);
    }

    public function logout(UserRequest $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

}
