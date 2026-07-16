<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRecord extends Model
{
    use LogsActivity;

    protected $fillable = [
        'vehicle_id', 'service_date', 'title', 'cost', 'next_service_date', 'notes', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
            'next_service_date' => 'date',
            'cost' => 'decimal:2',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue(): bool
    {
        return $this->next_service_date && $this->next_service_date->lt(today());
    }

    protected function getLogName(): string
    {
        return 'Maintenance '.$this->title;
    }
}
