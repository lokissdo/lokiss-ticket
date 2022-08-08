<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                $TrimmedDetail[] =
                    [
                        'name' => $temp['station']['name'],
                        'province_name' => $temp['station']['province_name'],
                        'district_name' => $temp['station']['district_name'],
                    ];
            }
            $each['schedule_detail'] = $TrimmedDetail;
            return $each;
        }, $scheduleArr);
    }
}

