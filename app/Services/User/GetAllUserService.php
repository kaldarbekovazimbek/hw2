<?php

namespace App\Services\User;

use App\Contracts\UsersRepositoryInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;

class GetAllUserService
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getAllUsers(): Collection
    {
        $users = $this->usersRepository->getAll();
        if ($users === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $users;
    }
}
