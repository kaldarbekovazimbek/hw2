<?php

namespace App\Services\Organization;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Models\Organization;

class GetByIdOrganizationService
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getOrganization(int $organizationId): Organization
    {
        $organization = $this->organizationRepository->getById($organizationId);

        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $organization;
    }

}
