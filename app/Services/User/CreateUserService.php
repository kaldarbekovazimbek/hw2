<?php

namespace App\Services\User;

use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\DuplicateException;
use App\Models\User;

class CreateUserService
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws DuplicateException
     */
    public function createUser(UsersDTO $usersDTO): ?User
    {

        $existingUsersEmail = $this->usersRepository->getByEmail($usersDTO->getEmail());

        if ($existingUsersEmail !== null){
            throw new DuplicateException('messages.object_with_number_or_email_exists', 409);
        }

        return $this->usersRepository->create($usersDTO);
    }
}
