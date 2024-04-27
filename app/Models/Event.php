<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'active',

        'calendar_id',
        'owner_id',

        'name',
        'description',
        'link',
        'color',
        'beginning',
        'ending',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function calendars(): BelongsToMany
    {
        return $this->belongsToMany(Calendar::class)->using(CalendarEvent::class);
    }
}
