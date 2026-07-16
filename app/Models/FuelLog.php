<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelLog extends Model
{
    protected $fillable = [
        'vehicle_id', 'trip_id', 'fueled_at', 'liters', 'cost', 'odometer', 'notes', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'fueled_at' => 'date',
            'liters' => 'decimal:2',
            'cost' => 'decimal:2',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
