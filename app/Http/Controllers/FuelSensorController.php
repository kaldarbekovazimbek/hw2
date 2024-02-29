<?php

namespace App\Http\Controllers;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\ExistsObjectException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\FuelSensorRequest;
use App\Http\Resources\FuelSensor\FuelSensorCollection;
use App\Http\Resources\FuelSensor\FuelSensorResource;
use App\Services\FuelSensor\CreateFuelSensorService;
use App\Services\FuelSensor\DeleteFuelSensorService;
use App\Services\FuelSensor\GetAllFuelSensorsService;
use App\Services\FuelSensor\GetByIdFuelSensorService;
use App\Services\FuelSensor\GetVehicleFuelSensorsService;
use App\Services\FuelSensor\UpdateFuelSensorService;
use Illuminate\Http\JsonResponse;

class FuelSensorController extends Controller
{

    public function __construct(

        private GetAllFuelSensorsService      $allFuelSensorsService,
        private GetByIdFuelSensorService      $getByIdFuelSensorService,
        private DeleteFuelSensorService       $deleteFuelSensorService,
        private GetVehicleFuelSensorsService  $getVehicleFuelSensorsService,
        private CreateFuelSensorService       $createFuelSensorService,
        private UpdateFuelSensorService       $updateFuelSensorService,

    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public
    function index(): FuelSensorCollection
    {
        $fuelSensors = $this->allFuelSensorsService->getAllFuelSensors();

        return new FuelSensorCollection($fuelSensors);

    }

    /**
     * Store a newly created resource in storage.
     * @throws ExistsObjectException
     */
    public
    function store(FuelSensorRequest $request): FuelSensorResource
    {
        $validatedData = $request->validated();

        $fuelSensor = $this->createFuelSensorService->createFuelSensor(FuelSensorDTO::fromArray($validatedData));

        return new FuelSensorResource($fuelSensor);
    }


    /**
     * @throws NotFoundException
     */
    public
    function show(int $fuelSensorId): FuelSensorResource
    {
        $fuelSensor = $this->getByIdFuelSensorService->getById($fuelSensorId);

        return new FuelSensorResource($fuelSensor);
    }

    /**
     * @throws ExistsObjectException
     */
    public
    function update(FuelSensorRequest $request, int $fuelSensorId): FuelSensorResource
    {

        $validatedData = $request->validated();

        $fuelSensor = $this->updateFuelSensorService->updateFuelSensor($fuelSensorId, FuelSensorDTO::fromArray($validatedData));

        return new FuelSensorResource($fuelSensor);
    }

    /**
     * @throws NotFoundException
     */
    public
    function destroy(int $fuelSensorId): JsonResponse
    {
        $fuelSensor = $this->deleteFuelSensorService->deleteFuelSensor($fuelSensorId);

        $fuelSensor->delete();

        return response()->json([
            'message' => 'Object was deleted'
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public
    function getVehicleSensors(int $vehicleId): FuelSensorCollection
    {
        $vehicleSensors = $this->getVehicleFuelSensorsService->getVehicleFuelSensors($vehicleId);

        return new FuelSensorCollection($vehicleSensors);
    }
}
