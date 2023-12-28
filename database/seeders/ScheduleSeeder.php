<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\ServiceProvider;
use App\Models\Station;
use Illuminate\Database\Seeder;
use Faker\Generator ;
use Illuminate\Container\Container;
class ScheduleSeeder extends Seeder
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
    private function get_random_value_for_schedule($service_provider_id){
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
            'service_provider_id' =>$service_provider_id
        ];
    }
    private function seed_schedule_all_service_providers(){
        $service_provider_ids=ServiceProvider::get('id');
        foreach ($service_provider_ids as  $each) {
            Schedule::create($this->get_random_value_for_schedule($each->id));
        }
    } 
    public function run()
    {
        Schedule::factory()->count(30)->create();
        $this->seed_schedule_all_service_providers();
    }
}
