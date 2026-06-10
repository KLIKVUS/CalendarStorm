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
        User::factory()
            ->count(5)
            ->create();

        Calendar::factory()
            ->count(20)
            ->create();

        Event::factory()
            ->count(150)
            ->create();

        CalendarEvent::factory()
            ->count(150)
            ->create();
    }
}
