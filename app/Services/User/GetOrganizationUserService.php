<?php

namespace App\Services\User;

use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetOrganizationUserService
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getOrganizationUsers(int $organizationId): Collection
    {
        /**
         * @var Organization $organization
         */
        $organization = $this->usersRepository->getOrganizationUsers($organizationId);

        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $organization->users()->get();


    }
}
