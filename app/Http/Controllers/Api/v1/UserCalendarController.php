<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Models\Calendar;

class UserCalendarController extends Controller
{
    public function index(string $user_id)
    {
        $calendars = Calendar::all()->where('owner_id', '=', $user_id)->all();

        return CalendarResource::collection($calendars)
            ->additional([
                'success' => true,
            ]);
    }
}
