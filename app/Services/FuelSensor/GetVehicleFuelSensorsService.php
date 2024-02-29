<?php

namespace App\Services\FuelSensor;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\ExistsObjectException;
use App\Exceptions\NotFoundException;
use App\Models\FuelSensor;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class GetVehicleFuelSensorsService
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;

    public function __construct(FuelSensorRepositoryInterface $fuelSensorRepository)
    {
        $this->fuelSensorRepository = $fuelSensorRepository;
    }

    /**
     * @throws NotFoundException
     */
    public function getVehicleFuelSensors(int $vehicleId): Collection
    {
        /**
         * @var Vehicle $vehicle
         */
        $vehicle = $this->fuelSensorRepository->getVehicleSensors($vehicleId);

        if ($vehicle === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $vehicle->fuelSensors()->get();
    }
}
