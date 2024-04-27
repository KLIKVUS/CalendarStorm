<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'active',

        'owner_id',

        'name',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->using(CalendarEvent::class);
    }
}
