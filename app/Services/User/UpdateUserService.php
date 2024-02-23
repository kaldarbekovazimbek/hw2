<?php

namespace App\Services\User;

use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\DuplicateException;
use App\Models\User;

class UpdateUserService
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function updateUser(int $userId, UsersDTO $usersDTO): ?User
    {
        $usersPhone = $this->usersRepository->getByPhone($usersDTO->getPhone());
        $usersEmail = $this->usersRepository->getByEmail($usersDTO->getEmail());

        if ($usersPhone !== null or $usersEmail !== null) {
            throw new DuplicateException('messages.object_with_number_or_email_exists', 409);
        }


        return $this->usersRepository->create($usersDTO);
    }
}
