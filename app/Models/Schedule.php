<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time'   => 'datetime',
    ];

    public const STATUS = [
        'Ticketing',
        'Onboarding',
        'Departing',
        'Arriving',
    ];


    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class)->withTrashed();
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class)->withTrashed();
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class)->withTrashed();
    }

    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Conductor::class)->withTrashed();
    }

    public function terminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class)->withTrashed();
    }
}
