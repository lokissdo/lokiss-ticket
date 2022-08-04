<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Station;
use Illuminate\Database\Seeder;

class ScheduleDetailSeeder extends Seeder
{
    private $maxScheduleID;
    private $maxMiddleStation;

    public function __construct()
    {
        $this->maxScheduleID = 40;
        $this->maxMiddleStation = 5;
    }
    public function run()
    {
        $schedules = Schedule::where('id', '>', $this->maxScheduleID)->get();
        $arrInsert=[];
        foreach ($schedules as $each) {
            $schedule_id = $each->id;
            $firstStation = Station::where('address', $each->departure_province_code)->orderByRaw('RAND()')->first();
            $lastStation = Station::where('address', $each->arrival_province_code)->orderByRaw('RAND()')->first();
            $numOfMiddleStation = rand(1, $this->maxMiddleStation);
            $arrScheDetail = [];
            $MiddleStations = Station::where('id', '<>', $firstStation->id)->where('id', '<>', $lastStation->id)
                ->orderByRaw('RAND()')->take($numOfMiddleStation)->get('id')->toArray();
            array_unshift($arrScheDetail, [
                'schedule_id' => $schedule_id,
                'station_id' => $lastStation->id,
                'next_station_id' => NULL
            ]);
            foreach ($MiddleStations as $station) {
                array_unshift($arrScheDetail, [
                    'schedule_id' => $schedule_id,
                    'station_id' => $station['id'],
                    'next_station_id' => $arrScheDetail[0]['station_id']
                ]);
            }
            array_unshift($arrScheDetail, [
                'schedule_id' => $schedule_id,
                'station_id' => $firstStation->id,
                'next_station_id' => $arrScheDetail[0]['station_id']
            ]);
            $arrInsert=array_merge($arrInsert,$arrScheDetail);
        }
        ScheduleDetail::insert($arrInsert);
    }
}
