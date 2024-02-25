<?php

namespace App\Contracts;

use App\DTO\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

interface OrganizationRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $organizationId): ?Organization;

    public function create(OrganizationDTO $organizationDTO):Organization;

    public function update(int $organizationId, OrganizationDTO $organizationDTO):?Organization;

    public function getByPhone(string $phone): ?Organization;
}
