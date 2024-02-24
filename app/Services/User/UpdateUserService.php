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

    /**
     * @throws DuplicateException
     */
    public function updateUser(int $userId, UsersDTO $usersDTO): ?User
    {
        /**
         * @var User $existingUsersEmail
         */
        $existingUsersEmail = $this->usersRepository->getByEmail($usersDTO->getEmail());

        if ($existingUsersEmail !== null && $existingUsersEmail->id !== $userId) {
            throw new DuplicateException(__('messages.object_with_email_exists', 409));
        }

        return $this->usersRepository->update($userId, $usersDTO);
    }
}
