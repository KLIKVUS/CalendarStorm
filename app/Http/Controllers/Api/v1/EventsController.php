<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\UpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $calendars = Event::all();

        return EventResource::collection($calendars)
            ->additional([
                'success' => true,
            ]);
    }

    public function show(Event $event)
    {
        return EventResource::make($event)
            ->additional([
                'success' => true,
            ]);
    }

    public function update(UpdateRequest $request, Event $event)
    {
        $data = $request->validated();
        $event->update($data);

        return EventResource::make($event)
            ->additional([
                'success' => true,
                'message' => 'Ивент обновлен.',
            ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ивент удален.',
        ]);
    }
}
