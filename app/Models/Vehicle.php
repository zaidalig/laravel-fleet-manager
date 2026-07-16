<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use LogsActivity;

    protected $fillable = [
        'plate_number', 'make', 'model', 'year', 'type', 'status', 'odometer', 'notes',
    ];

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function fuelLogs(): HasMany
    {
        return $this->hasMany(FuelLog::class);
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    protected function getLogName(): string
    {
        return 'Vehicle '.$this->plate_number;
    }
}
