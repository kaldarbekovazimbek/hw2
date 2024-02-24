<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'birthday' => $this->resource->birthday,
            'email' => $this->resource->email,
        ];

    }
}
