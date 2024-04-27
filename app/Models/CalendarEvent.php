<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CalendarEvent extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'calendar_id',
        'event_id',
    ];
}
