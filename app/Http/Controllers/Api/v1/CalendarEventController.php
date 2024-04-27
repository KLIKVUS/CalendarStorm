<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Models\Calendar;

class CalendarEventController extends Controller
{
    public function index(Calendar $calendar)
    {
        $calendar_events = $calendar->events;

        return CalendarResource::collection($calendar_events)
            ->additional([
                'success' => true,
            ]);
    }

    public function store()
    {
    }
}
