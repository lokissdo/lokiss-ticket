<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'arrival_time',
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
    // public function schedule_detail()
    // {
    //     return $this->hasOne(ScheduleDetail::class,'schedule_id','id'); 
    // }
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
    public function getDepartureTimeStrAttribute()
    {
        $deTime=intval($this->departure_time);
        return ( floor($deTime/60)).' : '.( $deTime%60);
    }
    public function getArrivalTimeStrAttribute()
    {
        $arTime=intval($this->arrival_time)%1440;
        return (floor($arTime /60)).' : '.($arTime %60);
    }
    public function getTotalDaysAttribute()
    {
        $arTime=intval($this->arrival_time);
        return (floor($arTime/1440));
    }
    public function get_informations_without_detail(){
        $this->append('departure_province_name');
        $this->append('arrival_province_name');
        $this->append('arrival_time_str');
        $this->append('departure_time_str');
        $this->append('total_days');
        $this->makeHidden([
            'arrival_province', 'departure_province',
            'departure_province_code', 'arrival_province_code', 'departure_time', 'arrival_time'
        ]);
    } 
}
