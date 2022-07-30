<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'price',
        'departure_date',
        'schedule_id',
        'service_provider_id',
        'coach_id'

    ];
    public function coach(){
        return $this->belongsTo(Coach::class); 
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class); 
    }
    static function get_trips($service_provider_id){
        $trips=Trip::where('service_provider_id',$service_provider_id)->with(['coach:id,name','schedule.arrival_province','schedule.departure_province'])->get();
        $trips = $trips->map(function ($item, $key) {  
             $item->schedule->get_informations_without_detail();
             $item->arrival_date=date('Y-m-d', strtotime($item->departure_date. ' + '.$item->schedule->total_days.' days'));
             $coachName=$item->coach->name;
             unset(
                $item->coach_id ,  $item->schedule->total_days, $item->service_provider_id , 
                $item->coach    , $item->schedule->id ,  $item->schedule->service_provider_id , 
                
            );
            $item->coach=$coachName;
             return $item;
        });
        return $trips;
    }
}
