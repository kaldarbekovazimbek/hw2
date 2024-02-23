<?php

namespace App\Services\FuelSensor;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\DuplicateException;
use App\Models\FuelSensor;

class CreateFuelSensorService
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;

    public function __construct(FuelSensorRepositoryInterface $fuelSensorRepository)
    {
        $this->fuelSensorRepository = $fuelSensorRepository;
    }

    /**
     * @throws DuplicateException
     */
    public function createFuelSensor(FuelSensorDTO $fuelSensorDTO): FuelSensor
    {
        $sensorNumber = $this->fuelSensorRepository->getFuelSensorBySerialNumber($fuelSensorDTO->getSerialNumber());
        if ($sensorNumber) {
            throw new DuplicateException(__('messages.object_with_serial_number_exists'), 409);
        }

        return $this->fuelSensorRepository->create($fuelSensorDTO);
    }
}
