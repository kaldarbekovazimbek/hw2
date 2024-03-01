<?php

namespace App\Services\User;

use App\Contracts\UsersRepositoryInterface;
use App\DTO\UserLoginDTO;
use App\DTO\UsersDTO;
use App\Exceptions\BadCredentialsException;
use App\Exceptions\ExistsObjectException;
use App\Exceptions\NotFoundException;
use App\Exceptions\NotVerifiedException;
use App\Http\Requests\UserLoginRequest;
use App\Jobs\SendConfirmationCodeJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthUserService
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws ExistsObjectException
     */
    public function register(UsersDTO $usersDTO): void
    {
        $userExisting = $this->usersRepository->getByEmail($usersDTO->getEmail());

        if ($userExisting !== null) {
            throw new ExistsObjectException(__('messages.object_with_email_exists'), 409);
        }

        $user = $this->usersRepository->create($usersDTO);

        $confirmationCode = rand(99999, 999999);

        Cache::put('confirmation_code_' . $user->email, $confirmationCode, 60 * 5);

        SendConfirmationCodeJob::dispatch($usersDTO->getEmail(), $confirmationCode);

    }

    /**
     * @throws BadCredentialsException
     */
    public function confirmationEmail(Request $request): void
    {
        $email = $request->input('email');
        $confirmCode = $request->input('confirmation_code');

        $cashedConfirmCode = Cache::get('confirmation_code_' . $email);

        if ($cashedConfirmCode != $confirmCode) {
            throw new BadCredentialsException(__('messages.invalid_credentials'), 403);
        }

        Cache::forget('confirmation_code_' . $email);

        $user = $this->usersRepository->getByEmail($email);

        $user['email_verified_at'] = now();

        $user->save();
    }

    /**
     * @throws BadCredentialsException
     * @throws NotVerifiedException
     * @throws NotFoundException
     */
    public function login(array $request)
    {

        $user = $this->usersRepository->getByEmail($request['email']);

        if($user === null ){
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        if ($user['email_verified_at'] === null){
            throw new NotVerifiedException(__('messages.email_not_verified'),403);
        }

        if (!$user || !Hash::check($request['password'], $user->password)) {

            throw new BadCredentialsException(__('messages.bad_credentials'));

        }

        return $user->createToken('auth-token')->plainTextToken;
    }

}
