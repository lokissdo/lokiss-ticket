<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use App\Models\Trip;
use Illuminate\Database\Seeder;
use Faker\Generator ;
use Illuminate\Container\Container;
class TripSeeder extends Seeder
{
    private $maxTripPerProvider;
    private $minTripPerProvider;
    protected $faker;

    public function __construct()
    {
        $this->maxTripPerProvider = 100;
        $this->minTripPerProvider = 50;
        $this->faker = $this->withFaker();

    }
    private function randomDate($diffDay)
    {
       // return date('Y-m-d',strtotime(date('Y-m-d') . ' + ' . $diffDay . ' days'));
       return "2022-09-20";
    }
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    public function run()
    {
        $service_providers = ServiceProvider::get('id');
        $TripsInserted = [];
        foreach ($service_providers as $each) {
            $numOfTrip = rand($this->minTripPerProvider, $this->maxTripPerProvider); 
            $coach_ids = Coach::where('service_provider_id', $each->id)->orderByRaw('RAND()')->get('id');
            $schedule_ids = Schedule::where('service_provider_id', $each->id)->orderByRaw('RAND()')->get('id');
            for ($i = 0; $i < $numOfTrip; $i++){
                $coach_id = $this->faker->randomElement($coach_ids)->id;
                $schedule_id =$this->faker->randomElement($schedule_ids)->id;
                $diffDay=rand(0,60);
                $TripsInserted[] = [
                    'coach_id' => $coach_id,
                    'schedule_id' => $schedule_id,
                    'service_provider_id' => $each->id,
                    'departure_date' => $this->randomDate($diffDay),
                    'price'=>rand(100000,1000000),
                ];
            }    
        }
        Trip::insert($TripsInserted);
    }
}
