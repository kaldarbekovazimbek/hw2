<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Vehicle[] $vehicles
 */
class FuelSensor extends Model
{
    use HasFactory;

    public $table = 'fuel_sensors';

    protected $fillable = [
        'model',
        'serial_number',
        'vehicle_id',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
