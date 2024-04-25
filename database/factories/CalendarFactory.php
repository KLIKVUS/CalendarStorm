<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calendar>
 */
class CalendarFactory extends Factory
{
    protected $model = Calendar::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->text(),
            'owner_id' => User::get()->random()->id,
        ];
    }
}
