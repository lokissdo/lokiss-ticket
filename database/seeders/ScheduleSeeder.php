<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\ServiceProvider;
use App\Models\Station;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::factory()->count(30)->create();

    }
}
