<?php

namespace App\Http\Controllers;

use App\Contracts\FuelSensorRepositoryInterface;
use App\DTO\FuelSensorDTO;
use App\Exceptions\DuplicateException;
use App\Http\Requests\FuelSensorRequest;
use App\Http\Resources\FuelSensor\FuelSensorCollection;
use App\Http\Resources\FuelSensor\FuelSensorResource;
use App\Services\FuelSensor\CreateFuelSensorService;
use App\Services\FuelSensor\UpdateFuelSensorService;
use Illuminate\Http\JsonResponse;

class FuelSensorController extends Controller
{
    private FuelSensorRepositoryInterface $fuelSensorRepository;
    private CreateFuelSensorService $createFuelSensorService;
    private UpdateFuelSensorService $updateFuelSensorService;

    public function __construct(
        FuelSensorRepositoryInterface $fuelSensorRepository,
        CreateFuelSensorService       $createFuelSensorService,
        UpdateFuelSensorService       $updateFuelSensorService
    )
    {
        $this->createFuelSensorService = $createFuelSensorService;
        $this->fuelSensorRepository = $fuelSensorRepository;
        $this->updateFuelSensorService = $updateFuelSensorService;
    }

    public function index(): FuelSensorCollection
    {
        $fuelSensors = $this->fuelSensorRepository->getAll();

        return new FuelSensorCollection($fuelSensors);

    }

    /**
     * Store a newly created resource in storage.
     * @throws DuplicateException
     */
    public function store(FuelSensorRequest $request): FuelSensorResource
    {
        $validatedData = $request->validated();

        $fuelSensor = $this->createFuelSensorService->createFuelSensor(FuelSensorDTO::fromArray($validatedData));

        return new FuelSensorResource($fuelSensor);
    }


    public function show(int $fuelSensorId): FuelSensorResource
    {
        $fuelSensor = $this->fuelSensorRepository->getById($fuelSensorId);

        return new FuelSensorResource($fuelSensor);
    }

    /**
     * @throws DuplicateException
     */
    public function update(FuelSensorRequest $request, int $fuelSensorId): FuelSensorResource
    {

        $validatedData = $request->validated();

        $fuelSensor = $this->updateFuelSensorService->updateFuelSensor($fuelSensorId, FuelSensorDTO::fromArray($validatedData));

        return new FuelSensorResource($fuelSensor);
    }

    public function destroy(int $fuelSensorId): JsonResponse
    {
       return $this->fuelSensorRepository->delete($fuelSensorId);

    }

    public function getVehicleSensors(int $vehicleId): FuelSensorCollection
    {
        $vehicleSensors = $this->fuelSensorRepository->getVehicleSensors($vehicleId);

        return new FuelSensorCollection($vehicleSensors);
    }
}
