<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    protected $casts = [
        'transit_points' => 'array',
    ];
}
