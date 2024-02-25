<?php

namespace App\Repositories;

use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\NotFoundException;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class UserRepository implements UsersRepositoryInterface
{

    public function getAll(): Collection
    {
        return User::all();
    }

    public function getById(int $userId): ?User
    {
        /**
         * @var User|null $user
         */
        $user = User::query()->find($userId);

        return $user;
    }

    public function create(UsersDTO $usersDTO): ?User
    {
        $user = new User();

        $user->name = $usersDTO->getName();
        $user->birthday = $usersDTO->getBirthday();
        $user->email = $usersDTO->getEmail();
        $user->password = bcrypt($usersDTO->getPassword());
        $user->save();

        return $user;
    }

    public function update(int $userId, UsersDTO $usersDTO): ?User
    {
        $user = $this->getById($userId);
        $user->name = $usersDTO->getName();
        $user->birthday = $usersDTO->getBirthday();
        $user->email = $usersDTO->getEmail();
        $user->password = bcrypt($usersDTO->getPassword());
        $user->save();

        return $user;
    }

    public function getByEmail(string $email): ?User
    {
        /**
         * @var User|null $user
         */
        $user = User::query()->where('email', '=', $email)->first();

        return $user;
    }


    public function getOrganizationUsers(int $organizationId): Organization
    {
        /**
         * @var Organization $organization
         */
        $organization = Organization::query()->find($organizationId);

        return $organization;
    }
}
