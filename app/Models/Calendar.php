<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->using(CalendarEvent::class);
    }
}
