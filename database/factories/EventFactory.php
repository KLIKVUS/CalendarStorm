<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $beginning = fake()->dateTimeThisMonth('+2 months');
        $ending = Carbon::parse($beginning)->addDays(5);

        return [
            'calendar_id' => Calendar::get()->random()->id,
            'owner_id' => User::get()->random()->id,

            'name' => fake()->sentence(),
            'description' => fake()->text(),
            'link' => fake()->url(),
            'color' => fake()->hexColor(),
            'beginning' => $beginning,
            'ending' => $ending,
        ];
    }
}
