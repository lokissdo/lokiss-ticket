<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $passenger= $this->faker->randomElement(User::where('role',UserRoleEnum::PASSENGER)->get());
        return [
            'name'=>$this->faker->company(),
            'phone_number'=>$this->faker->phoneNumber(),
            'employer_id'=>$passenger->id,
            'address'=>$this->faker->randomElement(Province::get('code'))->code
        ];
    }
}
