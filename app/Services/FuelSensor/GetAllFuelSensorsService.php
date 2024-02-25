<?php

namespace App\Services\FuelSensor;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Models\FuelSensor;

class GetAllFuelSensorsService
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;

    public function __construct(FuelSensorRepositoryInterface $fuelSensorRepository)
    {
        $this->fuelSensorRepository = $fuelSensorRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getAllFuelSensors()
    {
        $fuelSensors = $this->fuelSensorRepository->getAll();

        if ($fuelSensors === null){
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $fuelSensors;
    }

}
