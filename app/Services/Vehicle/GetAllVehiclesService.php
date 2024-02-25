<?php

namespace App\Services\Vehicle;

use App\Contracts\VehicleRepositoryInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;

class GetAllVehiclesService
{
    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getAllVehicles(): Collection
    {
        $vehicles = $this->vehicleRepository->getAll();

        if ($vehicles === null){
            throw new NotFoundException(__('messages.object_not_found'),404);
        }
        return $vehicles;

    }
}

