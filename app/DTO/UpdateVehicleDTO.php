<?php

namespace App\DTO;

class UpdateVehicleDTO
{
    private string $model;
    private int $serialNumber;
    private int $organizationId;

    public function __construct(string $model, int $serialNumber, int $organizationId)
    {
        $this->model = $model;
        $this->serialNumber = $serialNumber;
        $this->organizationId = $organizationId;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getSerialNumber(): int
    {
        return $this->serialNumber;
    }

    public function getOrganizationId(): int
    {
        return $this->organizationId;
    }

    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'serial_number' => $this->serialNumber,
            'organization_id' => $this->organizationId,
        ];
    }
}
