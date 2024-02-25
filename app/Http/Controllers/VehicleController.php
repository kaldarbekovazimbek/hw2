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
use App\Services\Vehicle\DeleteVehicleService;
use App\Services\Vehicle\GetAllVehiclesService;
use App\Services\Vehicle\GetByIdVehicleService;
use App\Services\Vehicle\GetOrganizationVehiclesService;
use App\Services\Vehicle\UpdateVehicleService;
use Illuminate\Http\JsonResponse;


class VehicleController extends Controller
{


    public function __construct(
        private CreateVehicleService           $createVehicleService,
        private UpdateVehicleService           $updateVehicleService,
        private GetAllVehiclesService          $GetAllVehicleService,
        private GetByIdVehicleService          $getByIdVehicleService,
        private DeleteVehicleService           $deleteVehicleService,
        private GetOrganizationVehiclesService $getOrganizationVehiclesService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     * @throws NotFoundException
     */
    public
    function index(): VehicleCollection
    {

        $vehicle = $this->GetAllVehicleService->getAllVehicles();

        return new VehicleCollection($vehicle);

    }

    /**
     * Store a newly created resource in storage.
     * @throws DuplicateException
     */
    public
    function store(VehicleRequest $request): VehicleResource
    {
        /**
         * @var Vehicle $vehicle
         */
        $validatedData = $request->validated();

        $vehicle = $this->createVehicleService->createVehicle(VehicleDTO::fromArray($validatedData));

        return new VehicleResource($vehicle);
    }

    /**
     * @throws NotFoundException
     */
    public
    function show(int $vehicleId): VehicleResource
    {
        $vehicle = $this->getByIdVehicleService->getVehiclesById($vehicleId);

        return new VehicleResource($vehicle);

    }


    /**
     * @throws DuplicateException
     * @throws NotFoundException
     */
    public
    function update(VehicleRequest $request, int $vehicleId): VehicleResource
    {

        $validatedData = $request->validated();

        $vehicle = $this->updateVehicleService->updateVehicle($vehicleId, VehicleDTO::fromArray($validatedData));

        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public
    function destroy(int $vehicleId): JsonResponse
    {
        $vehicle = $this->deleteVehicleService->deleteVehiclesById($vehicleId);

        $vehicle->delete();

        return response()->json([
            'message'=>__('messages.object_deleted'),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public
    function getOrganizationVehicles(int $organizationId): VehicleCollection
    {
        $organizationVehicles = $this->getOrganizationVehiclesService->organizationVehicles($organizationId);

        return new VehicleCollection($organizationVehicles);
    }
}
