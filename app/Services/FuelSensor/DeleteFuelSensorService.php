<?php

namespace App\Services\FuelSensor;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Models\FuelSensor;
use Illuminate\Http\JsonResponse;

class DeleteFuelSensorService
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;

    public function __construct(FuelSensorRepositoryInterface $fuelSensorRepository)
    {
        $this->fuelSensorRepository = $fuelSensorRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteFuelSensor(int $fuelSensorId): FuelSensor
    {
        /**
         * @var FuelSensor $fuelSensor
         */
        $fuelSensor = $this->fuelSensorRepository->getById($fuelSensorId);
        if ($fuelSensor === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $fuelSensor;
    }

}
