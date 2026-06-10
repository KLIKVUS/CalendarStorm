<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Юзер по умолчанию
        User::factory()
            ->create([
                'login' => 'root',
                'password' => 'password',
            ]);

        Calendar::factory()
            ->count(15)
            ->create();

        Event::factory()
            ->count(250)
            ->create();

        CalendarEvent::factory()
            ->count(250)
            ->create();
    }
}
