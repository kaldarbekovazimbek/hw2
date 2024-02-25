<?php

namespace App\Contracts;

use App\DTO\VehicleDTO;
use App\Models\Organization;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

interface VehicleRepositoryInterface
{
    public function getAll():Collection;

    public function getById(int $vehicleId): ?Vehicle;

    public function createVehicle(VehicleDTO $vehicleDTO):Vehicle;

    public function updateVehicle(int $vehicleId, VehicleDTO $vehicleDTO);


    public function getVehicleByNumber(int $serialNumber);

    public function getOrganizationVehicles(int $organizationId);
}
