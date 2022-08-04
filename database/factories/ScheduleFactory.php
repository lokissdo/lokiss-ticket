<?php

namespace Database\Factories;

use App\Models\ServiceProvider;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            $departure=$this->faker->randomElement(Station::get(['address']));
            do {
                $arrival=$this->faker->randomElement(Station::get(['address']));
            }
            while ($departure->address==$arrival->address);
            $departure_time=rand(0, 1380);
            $arrival_time=$departure_time+1440+rand(0,10000);
            return [
                'arrival_time' => $arrival_time,
                'arrival_province_code' =>  $arrival->address,
                'departure_time' => $departure_time,
                'departure_province_code' =>  $departure->address,
                'service_provider_id' => $this->faker->randomElement(ServiceProvider::get(['id']))
            ];
    }
}
