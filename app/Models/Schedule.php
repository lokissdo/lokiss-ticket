<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'duration',
        'service_provider_id',
        'departure_time',
        'arrival_province_code',
        'departure_province_code',

    ];
    public $timestamps = false;
    public function departure_province()
    {
        return $this->belongsTo(Province::class, 'departure_province_code', 'code');
    }
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
    public function schedule_detail()
    {
        return $this->hasMany(ScheduleDetail::class, 'schedule_id', 'id');
    }
    public function arrival_province()
    {
        return $this->belongsTo(Province::class, 'arrival_province_code', 'code');
    }
    public function getArrivalProvinceNameAttribute()
    {
        return  $this->arrival_province->name;
    }
    public function getDepartureProvinceNameAttribute()
    {
        return  $this->departure_province->name;
    }
    public function getHourDurationAttribute()
    {
        return (int)($this->duration / 60) . 'h' . (int)($this->duration % 60) . 'p';
    }


    
    static function get_schedules_list($service_provider_id = null, $schedule_id = null)
    {
        $query = Schedule::query();
        if ($service_provider_id != null) $query->where('service_provider_id', $service_provider_id);
        if ($schedule_id != null) $query->where('id', $schedule_id);

        $schedules = $query->with([
            'arrival_province', 'departure_province',
            'schedule_detail.station.province', 'schedule_detail.station.district'
        ])->get()
            ->map(function ($item) {
                $item->get_informations_without_detail();
                $item->schedule_detail = $item->schedule_detail->map(function ($scheDetailItem) {
                    return $scheDetailItem->get_station_informations();
                });
                return $item;
            });
        $schedulesArr = $schedules->toArray();
        $schedulesArr = Schedule::reOrderSchedules($schedulesArr);
        return $schedulesArr;
    }
    public function get_informations_without_detail($withScheduleLocations=true)
    {
        if($withScheduleLocations===true){
            $this->append('departure_province_name');
            $this->append('arrival_province_name');
        }
        $this->append('hour_duration');
        $this->makeHidden([
            'arrival_province', 'departure_province',
            'departure_province_code', 'arrival_province_code',
        ]);
    }

    public static function reOrderSchedules(array $scheduleArr)
    {
        return array_map(function ($each) {
            $each['schedule_detail'] = Station::orderStations($each['schedule_detail']);
            $each['schedule_detail']=array_column($each['schedule_detail'],'station');
            return $each;
        }, $scheduleArr);
    }
    public static function get_popular_schedule()
    {
        $popularItemsJson = Cache::remember('popular-schedules', 60 * 60 * 24, function () {
            //Log("getting popular-schedules");
            $itemReturnedNum = 6;
            $previousWeek = date('Y-m-d', strtotime(now() . ' - ' . '14 days'));
            $followingWeek = date('Y-m-d', strtotime(now() . ' + ' . '14 days'));
            $query = self::with(['arrival_province', 'departure_province'])
                ->join('trips', 'trips.schedule_id', '=', 'schedules.id')
                ->whereBetween('trips.departure_date', [$previousWeek, $followingWeek])
                ->groupBy('arrival_province_code', 'departure_province_code')
                ->select([
                    DB::raw('COUNT(trips.id) as count '), DB::raw('AVG(trips.price) as price'),
                    'arrival_province_code', 'departure_province_code', DB::raw('ROUND(AVG(schedules.duration),-1) as duration')
                ])
                ->orderByRaw('count DESC');
            $popularItems = $query->limit($itemReturnedNum)->get();
            $popularItems->append('hour_duration');
            return   $popularItems->toJson();
        });
        

        return json_decode($popularItemsJson);
    }
}
