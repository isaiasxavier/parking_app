<?php

namespace App\Models;

use App\Models\Scopes\Parking\UserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Parking Model
 *
 * Represents a parking session, including details about the user, vehicle, and parking zone.
 * Utilizes soft deletes to allow for historical data retention.
 *
 * @property int $id The model's primary key
 * @property int $user_id ID of the user who owns this parking session
 * @property int $vehicle_id ID of the vehicle involved in this parking session
 * @property int $zone_id ID of the parking zone where the vehicle is parked
 * @property Carbon $start_time The start time of the parking session
 * @property Carbon|null $stop_time The stop time of the parking session, null if active
 * @property int $total_price The total price of the parking session, stored in cents
 * @property Carbon|null $deleted_at The time the record was soft deleted
 * @property Carbon|null $created_at The time the record was created
 * @property Carbon|null $updated_at The time the record was last updated
 * @property-read User $user The user associated with this parking session
 * @property-read Vehicle $vehicle The vehicle involved in this parking session
 * @property-read Zone $zone The parking zone where the vehicle is parked
 *
 * @method static Builder|Parking active() Query scope to get only active parking sessions
 * @method static Builder|Parking stopped() Query scope to get only stopped parking sessions
 */
class Parking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'zone_id',
        'start_time',
        'stop_time',
        'total_price',
    ];

    /**
     * Automatically applies a global scope to all queries for the model to filter by the current user's ID.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope());
    }

    /**
     * Defines a one-to-many inverse relationship with the User model.
     *
     * @return BelongsTo The relationship query builder.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines a one-to-many inverse relationship with the Vehicle model.
     *
     * @return BelongsTo The relationship query builder.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Defines a one-to-many inverse relationship with the Zone model.
     *
     * @return BelongsTo The relationship query builder.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Scope a query to only include active parking sessions (those without a stop time).
     *
     * @param  Builder  $query  The initial query builder instance.
     * @return Builder The modified query builder instance.
     */
    public function scopeActive(Builder $query)
    {
        return $query->whereNull('stop_time');
    }

    /**
     * Scope a query to only include stopped parking sessions (those with a stop time).
     *
     * @param  Builder  $query  The initial query builder instance.
     * @return Builder The modified query builder instance.
     */
    public function scopeStopped(Builder $query)
    {
        return $query->whereNotNull('stop_time');
    }

    /**
     * Mutator to set the total price of the parking session.
     *
     * @param  mixed  $value  The value to be set.
     */
    public function setTotalPriceAttribute(mixed $value)
    {
        $this->attributes['total_price'] = $value;
    }

    /**
     * Accessor to get the total price of the parking session, converting it from cents to a decimal format.
     *
     * @param  mixed  $value  The stored value in cents.
     * @return float The total price converted to a decimal.
     */
    public function getTotalPriceAttribute(mixed $value)
    {
        return round($value / 100, 2);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:Y-m-d H:i:s',
            'stop_time' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
