<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;
    public function station()
    {
        return $this->hasOne(Station::class, 'id', 'station_id');
    }
    public function get_station_informations()
    {
        $this->station->append('province_name');
        $this->station->append('district_name');
        $this->station->makeHidden(['address', 'address2']);
    }
    public static function get_schedule_detail($schedule_id)
    {
        $scheduleDetail = ScheduleDetail::where('schedule_id', $schedule_id)->with(['station.province', 'station.district'])->get()
            ->map(function ($item) {
                $item->get_station_informations();
                return $item;
            });
        $scheduleDetailArr = $scheduleDetail->toArray();
        $scheduleDetailArr = Station::orderStations($scheduleDetailArr);
        $orderedStations = array_column($scheduleDetailArr, 'station');
        return $orderedStations;
    }
    public static function get_schedule_details(array $schedule_ids)
    {
        if(count($schedule_ids)===0) return [];
        $scheduleDetails = ScheduleDetail::whereIn('schedule_id', $schedule_ids)->with(['station.province', 'station.district'])->get()
            ->map(function ($item) {
                $item->get_station_informations();
                return $item;
            })->toArray();
        $detailsByScheduleId = [];
        foreach ($scheduleDetails as  $each) {
            $detailsByScheduleId[$each['schedule_id']][] = $each;
        }
        $detailsArr = array_map(function($item){
            $item = Station::orderStations($item);
            $item = array_column($item, 'station');
            return $item;
        },$detailsByScheduleId);
        return $detailsArr;
    }
}
