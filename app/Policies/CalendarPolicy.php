<?php

namespace App\Policies;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CalendarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Calendar $calendar): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Calendar $calendar): Response
    {
        return $user->id === $calendar->owner_id
            ? Response::allow()
            : Response::deny(__('You do not have the rights to interact with the calendar.'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Calendar $calendar): Response
    {
        return $user->id === $calendar->owner_id
            ? Response::allow()
            : Response::deny(__('You do not have the rights to interact with the calendar.'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Calendar $calendar): Response
    {
        return $user->id === $calendar->owner_id
            ? Response::allow()
            : Response::deny(__('You do not have the rights to interact with the calendar.'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Calendar $calendar): Response
    {
        return $user->id === $calendar->owner_id
            ? Response::allow()
            : Response::deny(__('You do not have the rights to interact with the calendar.'));
    }
}
