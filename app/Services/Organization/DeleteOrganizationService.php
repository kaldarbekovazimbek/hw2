<?php

namespace App\Services\Organization;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Exceptions\ExistsObjectException;
use App\Exceptions\NotFoundException;
use App\Models\Organization;

class DeleteOrganizationService
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteOrganization(int $organizationId): Organization
    {
        $organization = $this->organizationRepository->getById($organizationId);
        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $organization;
    }
}
