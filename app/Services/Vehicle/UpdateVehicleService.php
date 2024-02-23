<?php

namespace App\Services\Vehicle;

use App\DTO\VehicleDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Models\Vehicle;
use App\Repositories\VehicleRepository;

class UpdateVehicleService
{
    private VehicleRepository $vehicleRepository;
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }


    /**
     * @throws DuplicateException
     * @throws NotFoundException
     */
    public function updateVehicle(int $vehicleId, VehicleDTO $vehicleDTO): ?Vehicle
    {
        $vehicle = $this->vehicleRepository->getVehicleByNumber($vehicleDTO->getSerialNumber());

        if ($vehicle !== null){
            throw new DuplicateException(__('messages.object_with_serial_number_exists'), 409);
        }

        return $this->vehicleRepository->update($vehicleId, $vehicleDTO);

    }
}
