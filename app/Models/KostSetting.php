<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostSetting extends Model
{
    protected $fillable = [
        'kost_name',
        'admin_phone',
        'default_due_day',
        'standard_room_rate',
        'auto_reminder',
        'compact_report',
    ];

    protected $casts = [
        'auto_reminder' => 'boolean',
        'compact_report' => 'boolean',
    ];
}
