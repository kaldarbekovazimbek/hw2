<?php

namespace App\Http\Controllers;


use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\DuplicateException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Services\User\CreateUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UsersRepositoryInterface $repository;
    private CreateUserService $createUserService;
    private UpdateUserService $updateUserService;

    public function __construct(
        UsersRepositoryInterface $repository,
        CreateUserService        $createUserService,
        UpdateUserService        $updateUserService,

    )
    {
        $this->repository = $repository;
        $this->createUserService = $createUserService;
        $this->updateUserService = $updateUserService;
    }

    public function index(): ?UserCollection
    {
        $users = $this->repository->getAll();

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     * @throws DuplicateException
     */
    public function store(UserRequest $request): UserResource
    {
        $validatedData = $request->validated();

        $user = $this->createUserService->createUser(UsersDTO::fromArray($validatedData));

        return new UserResource($user);

    }

    public function show(int $userId): UserResource
    {
        $user = $this->repository->getById($userId);

        return new UserResource($user);
    }

    /**
     * @throws DuplicateException
     */
    public function update(UserRequest $request, int $userId): UserResource
    {
        $validatedData = $request->validated();

        $user = $this->updateUserService->updateUser($userId, UsersDTO::fromArray($validatedData));

        return new UserResource($user);
    }


    public function destroy(int $userId): JsonResponse
    {
        return $this->repository->delete($userId);
    }

    public function getOrganizationUsers(int $organizationId): UserCollection
    {
        $users = $this->repository->getOrganizationUsers($organizationId);

        return new UserCollection($users);
    }
}
