<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use LogsActivity;

    protected $fillable = [
        'trip_number', 'vehicle_id', 'driver_id', 'start_location', 'end_location',
        'started_at', 'ended_at', 'distance_km', 'purpose', 'status', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'distance_km' => 'decimal:1',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fuelLogs(): HasMany
    {
        return $this->hasMany(FuelLog::class);
    }

    protected function getLogName(): string
    {
        return 'Trip '.$this->trip_number;
    }
}
