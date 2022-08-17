<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    private $maxTripPerProvider;
    private $minTripPerProvider;

    public function __construct()
    {
        $this->maxTripPerProvider = 100;
        $this->minTripPerProvider = 50;
    }
    private function randomDate($diffDay)
    {
        return date('Y-m-d',strtotime(date('Y-m-d') . ' + ' . $diffDay . ' days'));
    }
    public function run()
    {
        $service_providers = ServiceProvider::get('id');
        $TripsInserted = [];
        foreach ($service_providers as $each) {
            $numOfTrip = rand($this->minTripPerProvider, $this->maxTripPerProvider); 
            for ($i = 0; $i < $numOfTrip; $i++){
                $coach_id = Coach::where('service_provider_id', $each->id)->orderByRaw('RAND()')->first()->id;
                $schedule_id = Schedule::where('service_provider_id', $each->id)->orderByRaw('RAND()')->first()->id;
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
