<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Exceptions\SuccessException;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\Vehicle\VehicleCollection;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Models\Organization;
use App\Models\Vehicle;
use Nette\ArgumentOutOfRangeException;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): VehicleCollection
    {
        $vehicle = Vehicle::all();

        return new VehicleCollection($vehicle);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request): VehicleResource
    {
        /**
         * @var Vehicle $vehicle
         */
        $validatedData = $request->validated();

        $vehicle = Vehicle::query()->create($validatedData);

        $vehicle->organizations()->associate($request->input('organization_id'));

        return new VehicleResource($vehicle);
    }
    /**
     * Display the specified resource.
     */
    public function show(int $vehicleId): VehicleResource
    {
        $vehicle = Vehicle::query()->find($vehicleId);

        if ($vehicle === null){
            throw new NotFoundException('Vehicle not found', 404);
        }

        return new VehicleResource($vehicle);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, int $vehicleId): VehicleResource
    {
        $vehicle = Vehicle::query()->find($vehicleId);
        if ($vehicle === null){
            throw new NotFoundException('Vehicle not found', 404);
        }
        $validatedData = $request->validated();

        $vehicle->update($validatedData);

        return new VehicleResource($vehicle);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $vehicleId)
    {
        $vehicle = Vehicle::query()->find($vehicleId);
        if ($vehicle === null){
            throw new NotFoundException('Vehicle not found', 404);
        }
        $vehicle->delete();

        return response()->json([
            'message'=>'Deleted',
        ]);

//        throw new SuccessException('Vehicle was deleted', 200);
    }

    public function getOrganizationVehicles(int $organizationId): VehicleCollection
    {
        /**
         * @var Organization $organization
         */
        $organization = Organization::query()->find($organizationId);

        if ($organization === null){
            throw new NotFoundException('Organization not found', 404);
        }
        $vehicles = $organization->vehicles()->get();

        return new VehicleCollection($vehicles);
    }
}
