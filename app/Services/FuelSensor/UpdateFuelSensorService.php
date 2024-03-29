<?php

namespace App\Services\FuelSensor;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\ExistsObjectException;
use App\Models\FuelSensor;

class UpdateFuelSensorService
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;

    public function __construct(FuelSensorRepositoryInterface $fuelSensorRepository)
    {
        $this->fuelSensorRepository= $fuelSensorRepository;
    }

    /**
     * @throws ExistsObjectException
     */
    public function updateFuelSensor(int $fuelSensorId, FuelSensorDTO $fuelSensorDTO): FuelSensor
    {
        /**
         * @var FuelSensor $existingSensorNumber
         */
        $existingSensorNumber = $this->fuelSensorRepository->getFuelSensorBySerialNumber($fuelSensorDTO->getSerialNumber());

        if ($existingSensorNumber !== null && $existingSensorNumber->id !== $fuelSensorId) {
            throw new ExistsObjectException(__('messages.object_with_serial_number_exists'), 409);
        }
        return $this->fuelSensorRepository->update($fuelSensorId, $fuelSensorDTO);
    }
}
