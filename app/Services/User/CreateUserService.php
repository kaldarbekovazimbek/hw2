<?php

namespace App\Services\User;

use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\ExistsObjectException;
use App\Models\User;

class CreateUserService
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws ExistsObjectException
     */
    public function createUser(UsersDTO $usersDTO): ?User
    {

        $existingUsersEmail = $this->usersRepository->getByEmail($usersDTO->getEmail());

        if ($existingUsersEmail !== null){
            throw new ExistsObjectException(__('messages.object_with_email_exists'), 409);
        }

        return $this->usersRepository->create($usersDTO);
    }
}
