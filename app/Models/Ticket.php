<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'arrival_station_id',
        'departure_station_id',
        'schedule_id',
        'trip_id',
        'user_id',
        'seat_position'
    ];
    public function arrival_station(){
        return $this->belongsTo(Station::class,'arrival_station_id','id'); 
    }
    public function departure_station(){
        return $this->belongsTo(Station::class,'departure_station_id','id'); 
    }
    public function trip(){
        return $this->belongsTo(Trip::class,'trip_id','id'); 
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id'); 
    }
    static function get_tickets(int $trip_id){
        $tickets=Ticket::where('trip_id',$trip_id)->with(['user','arrival_station','departure_station'])->get();
        return $tickets->toArray();
    }
}
