<?php

namespace App\Http\Controllers;

use App\Contracts\OrganizationRepositoryInterface;
use App\DTO\OrganizationDTO;
use App\Exceptions\ExistsObjectException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\Organization\OrganizationCollection;
use App\Http\Resources\Organization\OrganizationResource;
use App\Services\Organization\CreateOrganizationService;
use App\Services\Organization\DeleteOrganizationService;
use App\Services\Organization\GetAllOrganizationService;
use App\Services\Organization\GetByIdOrganizationService;
use App\Services\Organization\UpdateOrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{

    public function __construct(
        private GetAllOrganizationService $getAllOrganizationService,
        private GetByIdOrganizationService $getByIdOrganizationService,
        private CreateOrganizationService $createOrganizationService,
        private UpdateOrganizationService $updateOrganizationService,
        private DeleteOrganizationService $deleteOrganizationService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     * @throws NotFoundException
     */
    public
    function index(): OrganizationCollection
    {
        $organizations = $this->getAllOrganizationService->getAllOrganizations();

        return new OrganizationCollection($organizations);
    }

    /**
     * Store a newly created resource in storage.
     * @throws ExistsObjectException
     */
    public
    function store(OrganizationRequest $request): OrganizationResource
    {
        $validatedData = $request->validated();

        $organization = $this->createOrganizationService->creatOrganization(OrganizationDTO::fromArray($validatedData));

        return new OrganizationResource($organization);

    }

    /**
     * @throws NotFoundException
     */
    public
    function show(int $organizationId): OrganizationResource|JsonResponse
    {

        $organization = $this->getByIdOrganizationService->getOrganization($organizationId);
        return new OrganizationResource($organization);

    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public
    function update(OrganizationRequest $request, int $organizationId): OrganizationResource|JsonResponse
    {
        $validatedData = $request->validated();

        $organization = $this->updateOrganizationService->updateOrganization($organizationId, OrganizationDTO::fromArray($validatedData));

        return new OrganizationResource($organization);
    }

    /**
     * @throws NotFoundException
     */
    public
    function destroy(int $organizationId): JsonResponse
    {
        $organization = $this->deleteOrganizationService->deleteOrganization($organizationId);
        $organization->delete();

        return response()->json([
            'message'=>__('messages.object_deleted'),
        ]);
    }
}
