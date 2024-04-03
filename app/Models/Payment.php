<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Payment extends Model
{
    use HasJsonRelationships;

    public $timestamps = false;

    protected $casts = [
        'tickets_id' => 'array',
        'paid_at'    => 'datetime'
    ];

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'passenger_id',
            'id'
        )->withTrashed();
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class)->withTrashed();
    }

    public function tickets()
    {
        return $this->belongsToJson(
            related: Ticket::class,
            foreignKey: 'tickets_id',
            ownerKey: (new Ticket())->getKey()
        );
    }
}
