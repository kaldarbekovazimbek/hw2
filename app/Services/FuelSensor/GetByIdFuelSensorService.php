<?php

namespace App\Services\FuelSensor;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\ExistsObjectException;
use App\Exceptions\NotFoundException;
use App\Models\FuelSensor;

class GetByIdFuelSensorService
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;

    public function __construct(FuelSensorRepositoryInterface $fuelSensorRepository)
    {
        $this->fuelSensorRepository = $fuelSensorRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getById(int $fuelSensorId)
    {
        $fuelSensor = $this->fuelSensorRepository->getById($fuelSensorId);

        if ($fuelSensor === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $fuelSensor;

    }
}
