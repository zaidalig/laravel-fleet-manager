<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use LogsActivity;

    protected $fillable = [
        'employee_code', 'name', 'phone', 'license_number', 'license_expiry', 'status', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'license_expiry' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    protected function getLogName(): string
    {
        return 'Driver '.$this->name;
    }
}
