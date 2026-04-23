<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Models\Calendar;
use Illuminate\Http\Request;

class UserCalendarController extends Controller
{
    public function index(Request $request, string $user_id)
    {
        $data = $request->validate([
            'page' => ['integer'],
        ]);
        $calendars = Calendar::where('owner_id', $user_id)->simplePaginate(10, ['*'], 'page', $data['page'] ?? 1);

        return CalendarResource::collection($calendars)
            ->additional([
                'success' => true,
            ]);
    }
}
