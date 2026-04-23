<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $appends = [
        'is_user_can_update',
        'is_user_can_delete',
    ];

    protected function isUserCanUpdate(): Attribute
    {
        return new Attribute(
            get: function () {
                $user = auth()->user();

                return $user && $user->id === $this->owner_id;
            },
        );
    }

    protected function isUserCanDelete(): Attribute
    {
        return new Attribute(
            get: function () {
                $user = auth()->user();

                return $user && $user->id === $this->owner_id;
            },
        );
    }

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    public function calendars(): BelongsToMany
    {
        return $this->belongsToMany(Calendar::class)->using(CalendarEvent::class);
    }
}
