<?php

namespace App\Services\Vehicle;

use App\Contracts\VehicleRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class DeleteVehicleService
{
    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteVehiclesById(int $vehicleId): Vehicle
    {
        $vehicle = $this->vehicleRepository->getById($vehicleId);

        if ($vehicle === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $vehicle;

    }
}

