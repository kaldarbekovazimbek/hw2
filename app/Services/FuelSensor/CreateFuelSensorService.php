<?php

namespace App\Services\FuelSensor;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\ExistsObjectException;
use App\Models\FuelSensor;

class CreateFuelSensorService
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;

    public function __construct(FuelSensorRepositoryInterface $fuelSensorRepository)
    {
        $this->fuelSensorRepository = $fuelSensorRepository;
    }

    /**
     * @throws ExistsObjectException
     */
    public function createFuelSensor(FuelSensorDTO $fuelSensorDTO): FuelSensor
    {
        $existingSensorNumber = $this->fuelSensorRepository->getFuelSensorBySerialNumber($fuelSensorDTO->getSerialNumber());
        if ($existingSensorNumber !==null) {
            throw new ExistsObjectException(__('messages.object_with_serial_number_exists'), 409);
        }

        return $this->fuelSensorRepository->create($fuelSensorDTO);
    }
}
