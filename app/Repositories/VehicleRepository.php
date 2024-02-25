<?php

namespace App\Repositories;

use App\Contracts\VehicleRepositoryInterface;
use App\DTO\VehicleDTO;
use App\Exceptions\NotFoundException;
use App\Models\Organization;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function getAll(): Collection
    {
        return Vehicle::all();
    }

    public function getById(int $vehicleId): ?Vehicle
    {
        /**
         * @var Vehicle|null $vehicle
         */
        $vehicle = Vehicle::query()->find($vehicleId);

        return $vehicle;
    }

    public function createVehicle(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->model = $vehicleDTO->getModel();
        $vehicle->serial_number = $vehicleDTO->getSerialNumber();
        $vehicle->organization_id = $vehicleDTO->getOrganizationId();
        $vehicle->save();

        return $vehicle;
    }

    public function updateVehicle(int $vehicleId, VehicleDTO $vehicleDTO): ?Vehicle
    {
        $vehicle = $this->getById($vehicleId);
        $vehicle->model = $vehicleDTO->getModel();
        $vehicle->serial_number = $vehicleDTO->getSerialNumber();
        $vehicle->organization_id = $vehicleDTO->getOrganizationId();
        $vehicle->save();
        return $vehicle;
    }


    public function getVehicleByNumber(int $serialNumber): ?Vehicle
    {
        /**
         * @var Vehicle|null $vehicle
         */
        $vehicle = Vehicle::query()->where('serial_number', $serialNumber)->first();

        return $vehicle;
    }

    public function getOrganizationVehicles(int $organizationId): ?Organization
    {

        /**
         * @var Organization $organization
         */
        $organization = Organization::query()->find($organizationId);

        if (!$organization){
            return  null;
        }
        return $organization;

    }

}
