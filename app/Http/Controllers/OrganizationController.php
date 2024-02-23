<?php

namespace App\Http\Controllers;

use App\DTO\OrganizationDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\Organization\OrganizationCollection;
use App\Http\Resources\Organization\OrganizationResource;
use App\Repositories\OrganizationRepository;
use App\Services\Organization\CreateOrganizationService;
use App\Services\Organization\UpdateOrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    private CreateOrganizationService $createOrganizationService;
    private UpdateOrganizationService $updateOrganizationService;
    private OrganizationRepository $organizationRepository;
public function __construct(CreateOrganizationService $createOrganizationService, UpdateOrganizationService $updateOrganizationService, OrganizationRepository $repository)
{
    $this->createOrganizationService = $createOrganizationService;
    $this->updateOrganizationService = $updateOrganizationService;
    $this->organizationRepository = $repository;
}

    /**
     * Display a listing of the resource.
     * @throws NotFoundException
     */
    public function index(): OrganizationCollection
    {
        $organizations = $this->organizationRepository->getAll();

        return new OrganizationCollection($organizations);
    }

    /**
     * Store a newly created resource in storage.
     * @throws DuplicateException
     */
    public function store(OrganizationRequest $request): OrganizationResource
    {
        $validatedData = $request->validated();

        $organization = $this->createOrganizationService->creatOrganization(OrganizationDTO::fromArray($validatedData));

        return new OrganizationResource($organization);

    }

    public function show(int $organizationId): OrganizationResource|JsonResponse
    {
        $organization = $this->organizationRepository->getById($organizationId);

        return new OrganizationResource($organization);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(OrganizationRequest $request, int $organizationId): OrganizationResource|JsonResponse
    {
        $validatedData = $request->validated();

        $organization = $this->updateOrganizationService->updateOrganization($organizationId, OrganizationDTO::fromArray($validatedData));

        return new OrganizationResource($organization);
    }

    /**
     * @throws NotFoundException
     */
    public function destroy(int $organizationId): JsonResponse
    {
        return $this->organizationRepository->delete($organizationId);
    }
}
