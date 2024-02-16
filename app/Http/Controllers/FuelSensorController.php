<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\FuelSensorRequest;
use App\Http\Resources\FuelSensor\FuelSensorCollection;
use App\Http\Resources\FuelSensor\FuelSensorResource;
use App\Models\FuelSensor;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;

class FuelSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws NotFoundException
     */
    public function index(): FuelSensorCollection
    {
        $fuelSensors = FuelSensor::all();

        if ($fuelSensors === null) {
            throw new NotFoundException('Fuel sensors not found');
        }
        return new FuelSensorCollection($fuelSensors);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FuelSensorRequest $request): FuelSensorResource
    {
        /**
         * @var FuelSensor $fuelSensor
         */
        $validatedData = $request->validated();

        $fuelSensor = FuelSensor::query()->create($validatedData);

        $fuelSensor->vehicle()->associate($request->input('vehicle_id'));

        return new FuelSensorResource($fuelSensor);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $fuelSensorId): FuelSensorResource
    {
        $fuelSensor = FuelSensor::query()->find($fuelSensorId);
        if ($fuelSensor === null) {
            throw new NotFoundException('Fuel sensor not found', 404);
        }
        return new FuelSensorResource($fuelSensor);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(FuelSensorRequest $request, int $fuelSensorId): FuelSensorResource
    {
        $fuelSensor = FuelSensor::query()->find($fuelSensorId);
        if ($fuelSensor === null) {
            throw new NotFoundException('Fuel sensor not found', 404);
        }
        $validatedData = $request->validated();

        $fuelSensor->update($validatedData);

        return new FuelSensorResource($fuelSensor);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $fuelSensorId): JsonResponse
    {
        $fuelSensor = FuelSensor::query()->find($fuelSensorId);
        if ($fuelSensor === null) {
            throw new NotFoundException('Fuel sensor not found', 404);
        }
        return response()->json([
            'message'=>'Deleted',
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function getVehicleSensors(int $vehicleId): FuelSensorCollection
    {
        /**
         * @var Vehicle $vehicle
         */
        $vehicle = Vehicle::query()->find($vehicleId);
        if ($vehicle === null) {
            throw new NotFoundException('Vehicle not found', 404);
        }
        $fuelSensor = $vehicle->fuelSensors()->get();

        return new FuelSensorCollection($fuelSensor);
    }
}
