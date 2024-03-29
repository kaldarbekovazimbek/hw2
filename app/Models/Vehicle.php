<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Organization[] $organizations
 * @property int $id
 * @property string $model
 * @property int $serial_number
 * @property int $organization_id
 */
class Vehicle extends Model
{
    use HasFactory;

    public $table = 'vehicles';

    protected $fillable = [
        'model',
        'serial_number',
        'organization_id',
    ];

    public function fuelSensors(): HasMany
    {
        return $this->hasMany(FuelSensor::class);
    }

    public function organizations(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
