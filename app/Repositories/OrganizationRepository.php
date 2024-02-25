<?php

namespace App\Repositories;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getAll(): Collection
    {
        return Organization::all();
    }

    public function getById(int $organizationId): ?Organization
    {
        /**
         * @var Organization $organization
         */
        $organization = Organization::query()->find($organizationId);

        return $organization;
    }

    public function create(OrganizationDTO $organizationDTO): Organization
    {
        $organization = new Organization();
        $organization->company = $organizationDTO->getCompany();
        $organization->phone = $organizationDTO->getPhone();
        $organization->address = $organizationDTO->getAddress();
        $organization->save();

        return $organization;
    }


    public function update(int $organizationId, OrganizationDTO $organizationDTO): ?Organization
    {

        $organization = $this->getById($organizationId);
        $organization->company = $organizationDTO->getCompany();
        $organization->phone = $organizationDTO->getPhone();
        $organization->address = $organizationDTO->getAddress();
        $organization->save();

        return $organization;
    }

    public function getByPhone(string $phone): ?Organization
    {
        /**
         * @var Organization|null $organization
         */
        $organization = Organization::query()->where('phone', $phone)->first();

        return $organization;
    }
}
