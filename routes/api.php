<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\FuelSensorController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [AuthUserController::class, 'register']);
Route::post('/login', [AuthUserController::class, 'login']);
Route::post('/logout', [AuthUserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('check.token')->middleware('auth:sanctum')->group(function () {

    Route::get('/organizations', [OrganizationController::class, 'index'])->name('organization.index');
    Route::post('/organizations', [OrganizationController::class, 'store'])->name('organization.store');
    Route::get('/organizations/{organizationId}', [OrganizationController::class, 'show'])->name('organization.show');
    Route::match(['put', 'patch'], '/organizations/{organizationId}', [OrganizationController::class, 'update'])->name('organization.update');
    Route::delete('/organizations/{organizationId}', [OrganizationController::class, 'destroy'])->name('organization.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{userId}', [UserController::class, 'show'])->name('users.show');
    Route::match(['put', 'patch'], '/users/{userId}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{userId}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('organizations/{organizationId}/users', [UserController::class, 'getOrganizationUsers'])->name('users.getOrganizationUsers');

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{vehicleId}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::match(['put', 'patch'], '/vehicles/{vehicleId}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicleId}', [VehicleController::class, 'destroy'])->name('vehicles.update');
    Route::get('/organizations/{organizationId}/vehicles', [VehicleController::class, 'getOrganizationVehicles'])->name('vehicles.getOrganizationVehicles');

    Route::get('/sensors', [FuelSensorController::class, 'index'])->name('sensors.index');
    Route::post('/sensors', [FuelSensorController::class, 'store'])->name('sensors.store');
    Route::get('/sensors/{sensorId}', [FuelSensorController::class, 'show'])->name('sensors.show');
    Route::match(['put', 'patch'], '/sensors/{sensorId}', [FuelSensorController::class, 'update'])->name('sensors.update');
    Route::delete('/sensors/{sensorId}', [FuelSensorController::class, 'destroy'])->name('sensors.update');
    Route::get('/vehicles/{vehiclesId}/sensors', [FuelSensorController::class, 'getVehicleSensors'])->name('sensors.getVehicleSensors');

});



