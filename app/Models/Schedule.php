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
       return $this->hasOne(Province::class,'code','departure_province_code'); 
    }
    public function schedule_detail()
    {
        return $this->hasMany(ScheduleDetail::class,'schedule_id','id'); 
    }
    public function arrival_province(){
        return $this->hasOne(Province::class,'code','arrival_province_code'); 
     }
    public function getArrivalProvinceNameAttribute()
    {
        return  $this->arrival_province->name;
    }
    public function getDepartureProvinceNameAttribute()
    {
        return  $this->departure_province->name;;
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
}
