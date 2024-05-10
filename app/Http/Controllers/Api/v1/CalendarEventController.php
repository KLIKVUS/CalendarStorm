<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\CalendarEventsUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreRequest;
use App\Http\Resources\EventResource;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Event;

class CalendarEventController extends Controller
{
    public function index(Calendar $calendar)
    {
        $calendar_events = $calendar->events;

        return EventResource::collection($calendar_events)
            ->additional([
                'success' => true,
            ]);
    }

    public function store(Calendar $calendar, StoreRequest $request)
    {
        $data = $request->validated();
        $calendar_id = $calendar->id;
        $user_id = auth()->user()->id;
        $event = Event::create(array_merge($data, ['calendar_id' => $calendar_id, 'owner_id' => $user_id]));
        $event_id = $event->id;

        CalendarEvent::create([
            'calendar_id' => $calendar_id,
            'event_id' => $event_id,
        ]);

        CalendarEventsUpdate::dispatch($calendar);

        return EventResource::make($event)
            ->additional([
                'success' => true,
                'message' => 'Ивент сохранен.',
            ]);
    }
}
