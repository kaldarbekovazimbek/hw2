<?php

namespace App\Contracts;

use App\DTO\UsersDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


interface UsersRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $userId): ?User;

    public function create(UsersDTO $usersDTO): ?User;

    public function update(int $userId, UsersDTO $usersDTO): ?User;

    public function delete(int $userId);

    public function getOrganizationUsers(int $organizationId): Collection;

    public function getByEmail(string $email);

    public function getByPhone(string $phone);


}
