<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $company
 * @property string $phone
 * @property string $address
 */
class Organization extends Model
{
    use HasFactory;

    public $table = 'organizations';

    protected $fillable = [
        'company',
        'phone',
        'address',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function vehicles():HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
