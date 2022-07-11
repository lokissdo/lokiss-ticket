<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    public function getArrivalProvinceAttribute()
    {
        return  Province::where('code',$this->arrival_province_code)->first()->name;
    }
    public function getDepartureProvinceAttribute()
    {
        return  Province::where('code',$this->departure_province_code)->first()->name;
    }
}
