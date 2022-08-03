<?php

namespace Database\Factories;

use App\Enums\CoachTypesEnum;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_provider_id' => $this->faker->randomElement(ServiceProvider::get('id'))->id,
            'seat_number' => rand(10,50),
            'type' => $this->faker->randomElement(CoachTypesEnum::getValues()),
            'name'=>$this->faker->company(),
        ];
    }
}
