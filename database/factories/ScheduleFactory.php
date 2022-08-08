<?php

namespace Database\Factories;

use App\Models\ServiceProvider;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
   
    public function definition()
    {
        $departure = $this->faker->randomElement(Station::get(['address']));
        do {
            $arrival = $this->faker->randomElement(Station::get(['address']));
        } while ($departure->address == $arrival->address);
        $minutes_rand = rand(0, 1339);
        $departure_time = date('H:i:s', mktime(0, $minutes_rand, 0));
        $duration = rand(30, 2000);
        return [
            'duration' => $duration,
            'arrival_province_code' =>  $arrival->address,
            'departure_time' => $departure_time,
            'departure_province_code' =>  $departure->address,
            'service_provider_id' => $this->faker->randomElement(ServiceProvider::get(['id']))
        ];
    }
}
