<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;
    public function station()
    {
        return $this->hasOne(Station::class,'id','station_id'); 
    }
    public function get_station_informations(){
        $this->station->append('province_name');
        $this->station->append('district_name');
        $this->station->makeHidden(['address', 'address2']);
    } 
}
