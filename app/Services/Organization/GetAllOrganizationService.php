<?php

namespace App\Services\Organization;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Exceptions\ExistsObjectException;
use App\Exceptions\NotFoundException;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

class GetAllOrganizationService
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getAllOrganizations(): Collection
    {
        $organizations = $this->organizationRepository->getAll();

        if ($organizations === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $organizations;
    }


}
