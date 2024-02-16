<?php

namespace App\Http\Resources\Organization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id'=>$this->resource->id,
           'company'=>$this->resource->company,
           'phone'=>$this->resource->phone,
           'address'=>$this->resource->address,
        ];
    }
}
