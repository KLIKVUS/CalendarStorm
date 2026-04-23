<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'description',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $appends = [
        'is_user_can_update',
        'is_user_can_delete',
        'is_user_can_create_events',
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

    protected function isUserCanCreateEvents(): Attribute
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
        return $this->belongsToMany(Event::class)->when(
            auth()->user(),
            function (Builder $query, User $user) {
                if ($this->owner_id != $user->id) {
                    $query->where('active', true);
                }
            },
            function (Builder $query) {
                $query->where('active', true);
            }
        )
            ->using(CalendarEvent::class);
    }
}
