<?php

namespace App\Contracts;

use App\DTO\VehicleDTO;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

interface VehicleRepositoryInterface
{
    public function getAll():Collection;

    public function getById(int $vehicleId): ?Vehicle;

    public function create(VehicleDTO $vehicleDTO):Vehicle;

    public function update(int $vehicleId, VehicleDTO $vehicleDTO);

    public function delete(int $vehicleId);

    public function getVehicleByNumber(int $serialNumber);

    public function getOrganizationVehicles(int $organizationId);
}
