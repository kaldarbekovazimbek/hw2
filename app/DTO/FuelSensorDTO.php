<?php

namespace App\DTO;

class FuelSensorDTO
{
    private string $model;
    private int $serialNumber;
    private int $vehicleId;

    public function __construct(string $model, int $serialNumber, int $vehicleId)
    {
        $this->model = $model;
        $this->serialNumber = $serialNumber;
        $this->vehicleId = $vehicleId;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getSerialNumber(): int
    {
        return $this->serialNumber;
    }

    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            model: $data['model'],
            serialNumber: $data['serial_number'],
            vehicleId: $data['vehicle_id']
        );
    }
}
