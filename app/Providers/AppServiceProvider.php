<?php

namespace App\Providers;

use App\Contracts\FuelSensorRepositoryInterface;
use App\Contracts\OrganizationRepositoryInterface;
use App\Contracts\UsersRepositoryInterface;
use App\Contracts\VehicleRepositoryInterface;
use App\Http\Resources\Organization\OrganizationResource;
use App\Repositories\FuelSensorRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsersRepositoryInterface::class, UserRepository::class);
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(FuelSensorRepositoryInterface::class, FuelSensorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        OrganizationResource::withoutWrapping();

    }
}
