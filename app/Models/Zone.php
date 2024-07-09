<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Zone Model
 *
 * Represents a parking zone, including details such as the zone name and price per hour for parking.
 * Utilizes soft deletes to allow for historical data retention.
 *
 * @property int $id The model's primary key
 * @property string $name The name of the parking zone
 * @property int $price_per_hour The price per hour for parking in this zone, stored in cents
 * @property Carbon|null $deleted_at The time the record was soft deleted
 * @property Carbon|null $created_at The time the record was created
 * @property Carbon|null $updated_at The time the record was last updated
 */
class Zone extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price_per_hour',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_per_hour' => 'integer',
        ];
    }
}
