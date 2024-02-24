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
        $vehicle = Vehicle::all();

        return $vehicle;
    }

    /**
     * @throws NotFoundException
     */
    public function getById(int $vehicleId): ?Vehicle
    {
        /**
         * @var Vehicle|null $vehicle
         */
        $vehicle = Vehicle::query()->find($vehicleId);
        if ($vehicle === null) {
            throw new NotFoundException(__('messages.object_not_found'),404);
        }
        return $vehicle;
    }

    public function create(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->model = $vehicleDTO->getModel();
        $vehicle->serial_number = $vehicleDTO->getSerialNumber();
        $vehicle->organization_id = $vehicleDTO->getOrganizationId();
        $vehicle->save();

        return $vehicle;
    }

    /**
     * @throws NotFoundException
     */
    public function update(int $vehicleId, VehicleDTO $vehicleDTO): ?Vehicle
    {
        $vehicle = $this->getById($vehicleId);
        $vehicle->model = $vehicleDTO->getModel();
        $vehicle->serial_number = $vehicleDTO->getSerialNumber();
        $vehicle->organization_id = $vehicleDTO->getOrganizationId();
        $vehicle->save();
        return $vehicle;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $vehicleId): JsonResponse
    {
        $vehicle = $this->getById($vehicleId);
        if ($vehicle === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        $vehicle->delete();

        return response()->json([
            'message' => __('messages.object_deleted')
        ]);
    }

    public function getVehicleByNumber(int $serialNumber): ?Vehicle
    {
        /**
         * @var Vehicle|null $vehicle
         */
        $vehicle = Vehicle::query()->where('serial_number', $serialNumber)->first();

        return $vehicle;
    }

    /**
     * @throws NotFoundException
     */
    public function getOrganizationVehicles(int $organizationId): Collection
    {
        /**
         * @var Organization $organization
         */

        $organization = Organization::query()->find($organizationId);

        if ($organization === null) {
            throw new NotFoundException(__('messages.object_not_found'), 404);
        }
        return $organization->vehicles()->get();
    }

}
