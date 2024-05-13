<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Http\Requests\Calendar\StoreRequest;
use App\Http\Requests\Calendar\UpdateRequest;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'page' => ['integer'],
        ]);
        $calendars = Calendar::simplePaginate(10, ['*'], 'page', $data['page'] ?? 1);

        return CalendarResource::collection($calendars)
            ->additional([
                'success' => true,
            ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $user_id = auth()->user()->id;
        $calendar = Calendar::create(array_merge($data, ['owner_id' => $user_id]));

        return CalendarResource::make($calendar)
            ->additional([
                'success' => true,
                'message' => 'Календарь сохранен.',
            ]);
    }

    public function show(Calendar $calendar)
    {
        return CalendarResource::make($calendar)
            ->additional([
                'success' => true,
            ]);
    }

    public function update(UpdateRequest $request, Calendar $calendar)
    {
        $data = $request->validated();
        $calendar->update($data);

        return CalendarResource::make($calendar)
            ->additional([
                'success' => true,
                'message' => 'Календарь обновлен.',
            ]);
    }

    public function destroy(Calendar $calendar)
    {
        $calendar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Календарь удален.',
        ]);
    }
}
