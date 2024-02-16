<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\Organization\OrganizationCollection;
use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @throws NotFoundException
     */
    public function index(): OrganizationCollection
    {
        $organization = Organization::all();
        if ($organization === null) {
            throw new NotFoundException('Not found', 404);
        }
        return new OrganizationCollection($organization);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationRequest $request): OrganizationResource
    {

        $validatedData = $request->validated();

        $organization = Organization::query()->create($validatedData);

        return new OrganizationResource($organization);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $organizationId): OrganizationResource|JsonResponse
    {
        $organization = Organization::query()->find($organizationId);

        if ($organization === null) {
            throw new NotFoundException('Not found', 404);
        }

        return new OrganizationResource($organization);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(OrganizationRequest $request, int $organizationId): OrganizationResource|JsonResponse
    {
        $validatedData = $request->validated();

        $organization = Organization::query()->find($organizationId);

        if ($organization === null) {
            throw new NotFoundException('Not found', 404);
        }

        $organization->update($validatedData);

        return new OrganizationResource($organization);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $organizationId): JsonResponse
    {

        $organization = Organization::query()->find($organizationId);

        if ($organization === null) {
            throw new NotFoundException('Not found', 404);
        }
        $organization->delete();

        return response()->json([
            'message' => "Deleted"
        ]);
    }
}
