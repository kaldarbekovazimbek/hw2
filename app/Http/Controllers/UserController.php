<?php

namespace App\Http\Controllers;


use App\Contracts\UsersRepositoryInterface;
use App\DTO\UsersDTO;
use App\Exceptions\DuplicateException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Jobs\UserSendMail;
use App\Services\User\CreateUserService;
use App\Services\User\DeleteUserService;
use App\Services\User\GetAllUserService;
use App\Services\User\GetByIdUserService;
use App\Services\User\GetOrganizationUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{


    public function __construct(
        private GetAllUserService          $getAllUserService,
        private GetByIdUserService         $getByIdUserService,
        private CreateUserService          $createUserService,
        private UpdateUserService          $updateUserService,
        private GetOrganizationUserService $getOrganizationUserService,
        private DeleteUserService          $deleteUserService,

    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function index(): ?UserCollection
    {
        $users = $this->getAllUserService->getAllUsers();

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

        UserSendMail::dispatch($user);

        return new UserResource($user);
    }

    /**
     * @throws NotFoundException
     */
    public function show(int $userId): UserResource
    {
        $user = $this->getByIdUserService->getUserById($userId);

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


    /**
     * @throws NotFoundException
     */
    public function destroy(int $userId): JsonResponse
    {
        $user = $this->deleteUserService->deleteUser($userId);
        $user->delete();

        return response()->json([
            'message'=>__('messages.object_deleted'),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function getOrganizationUsers(int $organizationId): UserCollection
    {
        $users = $this->getOrganizationUserService->getOrganizationUsers($organizationId);

        return new UserCollection($users);
    }
}
