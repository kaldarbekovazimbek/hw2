<?php

namespace App\Services\Organization;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Exceptions\NotFoundException;
use App\Models\Organization;

class UpdateOrganizationService
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }


    /**
     * @throws NotFoundException
     */
    public function updateOrganization(int $organizationId, OrganizationDTO $organizationDTO): Organization
    {
        $existingOrganization = $this->organizationRepository->getByPhone($organizationDTO->getPhone());

        if ($existingOrganization !== null && $existingOrganization->id !== $organizationId){
            throw new NotFoundException(__('messages.object_with_serial_number_exists'), 409);
        }

        return $this->organizationRepository->update($organizationId, $organizationDTO);

    }
}
