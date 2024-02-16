<?php

namespace App\Http\Resources\FuelSensor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FuelSensorResource extends JsonResource
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
            'model'=>$this->resource->model,
            'serial_number'=>$this->resource->serial_number,
            'vehicle_id'=>$this->resource->vehicle_id,
        ];
    }
}
