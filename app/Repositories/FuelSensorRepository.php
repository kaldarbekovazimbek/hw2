<?php

namespace App\Repositories;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\NotFoundException;
use App\Models\FuelSensor;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class FuelSensorRepository implements FuelSensorRepositoryInterface
{

    public function getAll(): Collection
    {
        return FuelSensor::all();

    }

    /**
     * @throws NotFoundException
     */
    public function getById(int $sensorId): ?FuelSensor
    {
        /**
         * @var FuelSensor|null $fuelSensor
         */
        $fuelSensor = FuelSensor::query()->find($sensorId);

        if ($fuelSensor === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }

        return $fuelSensor;
    }

    public function create(FuelSensorDTO $fuelSensorDTO): FuelSensor
    {
        $fuelSensor = new FuelSensor();
        $fuelSensor->model = $fuelSensorDTO->getModel();
        $fuelSensor->serial_number = $fuelSensorDTO->getSerialNumber();
        $fuelSensor->vehicle_id = $fuelSensorDTO->getVehicleId();
        $fuelSensor->save();

        return $fuelSensor;

    }

    /**
     * @throws NotFoundException
     */
    public function update(int $sensorId, FuelSensorDTO $fuelSensorDTO): FuelSensor
    {
        $fuelSensor = $this->getById($sensorId);
        $fuelSensor->model = $fuelSensorDTO->getModel();
        $fuelSensor->serial_number = $fuelSensorDTO->getSerialNumber();
        $fuelSensor->vehicle_id = $fuelSensorDTO->getVehicleId();
        $fuelSensor->save();

        return $fuelSensor;
    }

    public function getFuelSensorBySerialNumber(int $serialNumber): ?FuelSensor
    {
        /**
         * @var FuelSensor|null $fuelSensor
         */
        $fuelSensor = FuelSensor::query()->where('serial_number', $serialNumber)->first();
        return $fuelSensor;
    }

    public function getVehicleSensors(int $vehicleId): ?Vehicle
    {
        /**
         * @var Vehicle $vehicle
         */
        $vehicle = Vehicle::query()->find($vehicleId);
        if (!$vehicle) {
            return null;
        }
        return $vehicle;
    }
}
