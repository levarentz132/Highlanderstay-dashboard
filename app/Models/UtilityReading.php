<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilityReading extends Model
{
    protected $fillable = [
        'period',
        'electricity_kwh',
        'water_m3',
        'electricity_cost',
        'water_cost',
        'recorded_at',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'date',
    ];
}
