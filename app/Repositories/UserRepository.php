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

    /**
     * @throws NotFoundException
     */
    public function getAll(): Collection
    {

        $users = User::all();

        if ($users === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $users;
    }

    /**
     * @throws NotFoundException
     */
    public function getById(int $userId): ?User
    {
        /**
         * @var User|null $user
         */
        $user = User::query()->find($userId);

        if ($user === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $user;
    }

    public function create(UsersDTO $usersDTO): ?User
    {
        $user = new User();

        $user->name = $usersDTO->getName();
        $user->birthday = $usersDTO->getBirthday();
        $user->email = $usersDTO->getEmail();
        $user->phone = $usersDTO->getPhone();
        $user->password = bcrypt($usersDTO->getPassword());
        $user->save();

        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function update(int $userId, UsersDTO $usersDTO): ?User
    {
        $user = $this->getById($userId);
        $user->birthday = $usersDTO->getBirthday();
        $user->email = $usersDTO->getEmail();
        $user->phone = $usersDTO->getPhone();
        $user->password = bcrypt($usersDTO->getPassword());
        $user->save();

        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $userId): JsonResponse
    {
        $user = $this->getById($userId);

        if ($user === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        $user->delete();
        return response()->json([
            'message' => __('messages.object_deleted')
        ]);
    }

    public function getByEmail(string $email): ?User
    {
        /**
         * @var User|null $userEmail
         */
        $userEmail = User::query()->where('email', $email)->first();

        return $userEmail;
    }

    public function getByPhone(string $phone): ?User
    {
        /**
         * @var User|null $userPhone
         */
        $userPhone = User::query()->where('phone', $phone)->first();
        return $userPhone;
    }

    /**
     * @throws NotFoundException
     */
    public function getOrganizationUsers(int $organizationId): Collection
    {
        $organization = Organization::query()->find($organizationId);
        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        /**
         * @var Organization $organization
         */
        return $organization->users()->get();
    }
}
