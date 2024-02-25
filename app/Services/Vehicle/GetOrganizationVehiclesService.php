<?php

namespace App\Services\Vehicle;

use App\Contracts\VehicleRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class GetOrganizationVehiclesService
{
    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function organizationVehicles(int $organizationId): Collection
    {
        $organization = $this->vehicleRepository->getOrganizationVehicles($organizationId);

        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $organization->vehicles()->get();

    }
}

