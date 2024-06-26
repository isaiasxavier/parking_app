<?php

namespace App\Models;

use App\Models\Scopes\Parking\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Parking
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

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('stop_time');
    }

    public function scopeStopped($query)
    {
        return $query->whereNotNull('stop_time');
    }

    public function setTotalPriceAttribute($value)
    {
        $this->attributes['total_price'] = $value;
    }

    public function getTotalPriceAttribute($value)
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
