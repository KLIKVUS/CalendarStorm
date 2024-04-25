<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $beginning = fake()->dateTimeThisMonth('+2 months');
        $ending = Carbon::parse($beginning)->addDays(5);

        return [
            'name' => fake()->sentence(),
            'description' => fake()->text(),
            'link' => fake()->url(),
            'color' => fake()->hexColor(),
            'beginning' => $beginning,
            'ending' => $ending,
            'calendar_id' => Calendar::get()->random()->id,
        ];
    }
}
