<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function departure_province(){
       return $this->belongsTo(Province::class,'departure_province_code','code'); 
    }
    public function trips(){
        return $this->hasMany(Trip::class); 
     }
    public function schedule_detail()
    {
        return $this->hasMany(ScheduleDetail::class,'schedule_id','id'); 
    }
    public function arrival_province(){
        return $this->belongsTo(Province::class,'arrival_province_code','code'); 
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
        return (int)($this->duration/60).'h'.(int)($this->duration%60).'p';
    }
    public function get_informations_without_detail(){
        $this->append('departure_province_name');
        $this->append('arrival_province_name');
        $this->append('hour_duration');
        $this->makeHidden([
            'arrival_province', 'departure_province',
            'departure_province_code', 'arrival_province_code',
        ]);
    } 

    public static function reOrderSchedules( array $scheduleArr)
    {
        return array_map(function ($each) {
            $each['schedule_detail'] = Station::orderStations($each['schedule_detail']);
            $TrimmedDetail = [];
            foreach ($each['schedule_detail'] as $temp) {
                $TrimmedDetail[] = $temp['station'];
            }
            $each['schedule_detail'] = $TrimmedDetail;
            return $each;
        }, $scheduleArr);
    }
    public static function get_popular_schedule(){
        $itemReturnedNum=6;
        $previousWeek=date('Y-m-d',strtotime(now().' - '.'14 days'));
        $followingWeek=date('Y-m-d',strtotime(now().' + '.'14 days'));
        $query=self::with(['arrival_province','departure_province'])
        ->join('trips', 'trips.schedule_id', '=', 'schedules.id')
        ->whereBetween('trips.departure_date',[$previousWeek,$followingWeek])
        ->groupBy('schedules.id')
        ->select([DB::raw('COUNT(trips.id) as count '),DB::raw('AVG(trips.price) as price'),'schedules.*'])
        ->orderByRaw('count DESC');
        $popularItems=$query->limit($itemReturnedNum)->get();
        $popularItems->append('hour_duration');


        return $popularItems->toArray();
    }
}

