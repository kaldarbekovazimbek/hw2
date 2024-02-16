<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws NotFoundException
     */
    public function index(): UserCollection
    {
        $users = User::all();

        if ($users === null) {
            throw new NotFoundException('Not found', 404);
        }

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request, ): UserResource
    {
        /**
         * @var User $user
         */
        $validatedData = $request->validated();

        $user = User::query()->create($validatedData);

        $organization = Organization::query()->find($request->input('organization_id'));
        $user->organizations()->attach($organization);

        return new UserResource($user);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $userId): UserResource
    {
        $user = User::query()->find($userId);

        if ($user === null) {
            throw new NotFoundException('Not found', 404);
        }

        return new UserResource($user);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, int $userId): UserResource
    {
        $user = User::query()->find($userId);

        if ($user === null) {
            throw new NotFoundException('Not found', 404);
        }

        $validatedData = $request->validated();

        $user->create($validatedData);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId): JsonResponse
    {
        $user = User::query()->find($userId);

        if ($user === null) {
            throw new NotFoundException('Not found', 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Deleted',
        ]);
    }

    public function getOrganizationUsers(int $organizationId): UserCollection
    {

        /**
         * @var Organization $organization
         */
        $organization = Organization::query()->find($organizationId);

        if ($organization === null){
            throw new NotFoundException('Organization not found', 404);
        }

        $user = $organization->users()->get();

        return new UserCollection($user);
    }
}
