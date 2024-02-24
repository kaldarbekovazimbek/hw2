<?php

namespace App\Http\Controllers;

use App\Contracts\VehicleRepositoryInterface;
use App\DTO\VehicleDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\Vehicle\VehicleCollection;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Models\Vehicle;
use App\Services\Vehicle\CreateVehicleService;
use App\Services\Vehicle\UpdateVehicleService;


class VehicleController extends Controller
{
    private VehicleRepositoryInterface $vehicleRepository;
    private CreateVehicleService $createVehicleService;
    private UpdateVehicleService $updateVehicleService;

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        CreateVehicleService       $createVehicleService,
        UpdateVehicleService       $updateVehicleService
    )
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->createVehicleService = $createVehicleService;
        $this->updateVehicleService = $updateVehicleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): VehicleCollection
    {

        $vehicle = $this->vehicleRepository->getAll();

        return new VehicleCollection($vehicle);

    }

    /**
     * Store a newly created resource in storage.
     * @throws DuplicateException
     */
    public function store(VehicleRequest $request): VehicleResource
    {
        /**
         * @var Vehicle $vehicle
         */
        $validatedData = $request->validated();

        $vehicle = $this->createVehicleService->createVehicle(VehicleDTO::fromArray($validatedData));

        return new VehicleResource($vehicle);
    }

    public function show(int $vehicleId): VehicleResource
    {
        $vehicle = $this->vehicleRepository->getById($vehicleId);

        return new VehicleResource($vehicle);

    }


    /**
     * @throws DuplicateException
     * @throws NotFoundException
     */
    public function update(VehicleRequest $request, int $vehicleId): VehicleResource
    {

        $validatedData = $request->validated();

        $vehicle = $this->updateVehicleService->updateVehicle($vehicleId, VehicleDTO::fromArray($validatedData));

        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $vehicleId)
    {
        return $this->vehicleRepository->delete($vehicleId);

    }

    public function getOrganizationVehicles(int $organizationId): VehicleCollection
    {
        $organizationVehicles = $this->vehicleRepository->getOrganizationVehicles($organizationId);

        return new VehicleCollection($organizationVehicles);
    }
}
