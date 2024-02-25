<?php

namespace App\Services\User;

use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Models\User;

class GetByIdUserService
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getUserById(int $userId): User
    {
        $user = $this->usersRepository->getById($userId);
        if ($user === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $user;
    }

}
