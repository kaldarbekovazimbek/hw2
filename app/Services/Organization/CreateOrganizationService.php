<?php

namespace App\Services\Organization;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Exceptions\ExistsObjectException;
use App\Models\Organization;

class CreateOrganizationService
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @throws ExistsObjectException
     */
    public function creatOrganization(OrganizationDTO $organizationDTO): Organization
    {
        $organization = $this->organizationRepository->getByPhone($organizationDTO->getPhone());

        if ($organization !== null) {

            throw new ExistsObjectException(__('messages.object_with_serial_number_exists'), 409);
        }

        return $this->organizationRepository->create($organizationDTO);
    }
}
