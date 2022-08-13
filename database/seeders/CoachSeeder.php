<?php

namespace Database\Seeders;

use App\Enums\CoachTypesEnum;
use App\Models\Coach;
use App\Models\ServiceProvider;
use Faker\Generator ;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;

class CoachSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    private function seed_coach_all_service_providers(){
        $service_provider_ids=ServiceProvider::get('id');
        foreach ($service_provider_ids as  $each) {
            Coach::create([
            'service_provider_id' => $each->id,
            'seat_number' => rand(10, 50),
            'type' => $this->faker->randomElement(CoachTypesEnum::getValues()),
            'name' => $this->faker->company(),
            'photo' => 'provider/15/n5t0eoAXw2tdgdCjlkKQY8qZJPgZYqHxBAzUnKgA.jpg'
            ]);
        }
    } 
    public function run()
    {
       // Coach::factory()->count(10)->create();
       //$this->seed_coach_all_service_providers();
    }
}
