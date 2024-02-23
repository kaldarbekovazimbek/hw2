<?php

namespace App\Contracts;

use App\DTO\FuelSensorDTO;
use App\Models\FuelSensor;
use Illuminate\Database\Eloquent\Collection;

interface FuelSensorRepositoryInterface
{
    public function getAll();

    public function getById(int $sensorId);

    public function create(FuelSensorDTO $fuelSensorDTO): FuelSensor;

    public function update(int $sensorId, FuelSensorDTO $fuelSensorDTO): FuelSensor;

    public function delete(int $sensorId);

    public function getFuelSensorBySerialNumber(int $serialNumber);

    public function getVehicleSensors(int $vehicleId): Collection;
}
