<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $location=$this->faker->randomElement(District::get(['code','province_code']));
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' =>  $this->faker->password, // password
            'remember_token' => Str::random(10),
            'avatar' => $this->faker->imageUrl(),
            'address' => $location->province_code,
            'address2'=>  $location->code,
            'role' => $this->faker->randomElement(UserRoleEnum::getValues()),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
