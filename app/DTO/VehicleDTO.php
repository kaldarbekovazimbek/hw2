<?php

namespace App\DTO;

class VehicleDTO
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

    public static function fromArray($date): static
    {
        return new static(
            model: $date['model'],
            serialNumber: $date['serial_number'] ?? null,
            organizationId: $date['organization_id']
        );
    }
}
