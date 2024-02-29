<?php

namespace App\Services\Vehicle;

use App\Contracts\VehicleRepositoryInterface;
use App\DTO\VehicleDTO;
use App\Exceptions\ExistsObjectException;
use App\Models\Vehicle;

class CreateVehicleService
{
    private VehicleRepositoryInterface $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @throws ExistsObjectException
     */
    public function createVehicle(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicle = $this->vehicleRepository->getVehicleByNumber($vehicleDTO->getSerialNumber());

        if ($vehicle !== null) {
            throw new ExistsObjectException(__('messages.object_with_serial_number_exists'), 409);
        }
        return $this->vehicleRepository->createVehicle($vehicleDTO);
    }

}
