<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }
}
