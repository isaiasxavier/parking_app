<?php

namespace App\Models;

use App\Models\Scopes\Parking\ActiveScope;
use App\Models\Scopes\Parking\StoppedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScopes([
            new ActiveScope(),
            new StoppedScope(),
        ]);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'stop_time' => 'datetime',
        ];
    }
}
