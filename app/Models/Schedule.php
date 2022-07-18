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
    public function getArrivalProvinceAttribute()
    {
        return  Province::where('code',$this->arrival_province_code)->first()->name;
    }
    public function getDepartureProvinceAttribute()
    {
        return  Province::where('code',$this->departure_province_code)->first()->name;
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
