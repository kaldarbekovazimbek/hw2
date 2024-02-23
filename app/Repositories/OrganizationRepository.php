<?php

namespace App\Repositories;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Exceptions\NotFoundException;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class OrganizationRepository implements OrganizationRepositoryInterface
{

    /**
     * @throws NotFoundException
     */
    public function getAll(): Collection
    {
        $organizations = Organization::all();

        if ($organizations === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $organizations;
    }

    public function getById(int $organizationId): ?Organization
    {
        /**
         * @var Organization $organization
         */
        $organization = Organization::query()->find($organizationId);
        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
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

    /**
     * @throws NotFoundException
     */
    public function update(int $organizationId, OrganizationDTO $organizationDTO): ?Organization
    {

        $organization = $this->getById($organizationId);
        $organization->company = $organizationDTO->getCompany();
        $organization->phone = $organizationDTO->getPhone();
        $organization->address = $organizationDTO->getAddress();
        $organization->save();

        return $organization;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $organizationId): JsonResponse
    {
        $organization = Organization::query()->find($organizationId);
        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        $organization->delete();

        return response()->json([
            'message' =>__('messages.object_deleted')
        ]);

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
