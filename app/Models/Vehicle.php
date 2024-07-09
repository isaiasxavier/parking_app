<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Vehicle Model
 *
 * Represents a vehicle owned by a user, including details such as the user it belongs to and its plate number.
 * Utilizes soft deletes to allow for historical data retention.
 *
 * @property int $id The model's primary key
 * @property int $user_id ID of the user who owns this vehicle
 * @property string $plate_number The plate number of the vehicle
 * @property Carbon|null $deleted_at The time the record was soft deleted
 * @property Carbon|null $created_at The time the record was created
 * @property Carbon|null $updated_at The time the record was last updated
 * @property-read User $user The user associated with this vehicle
 */
class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'plate_number',
    ];

    /**
     * Defines a one-to-many inverse relationship with the User model.
     *
     * @return BelongsTo The relationship query builder.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
