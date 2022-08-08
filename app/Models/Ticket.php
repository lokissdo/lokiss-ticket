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
        $ticketsArr= $tickets->toArray();
        $ticketsArr=self::get_necessary_informations($ticketsArr);
        return $ticketsArr;
    }
    protected function get_necessary_informations($ticketsArr){
        return array_map(function ($item) {
            $user = [
                'id' => $item['user_id'],
                'name' => $item['user']['name'],
                'email' => $item['user']['email'],
                'avatar' => $item['user']['avatar'],
                'phone_number' => $item['user']['phone_number'],
            ];
            $arrival_station = [
                'name' => $item['arrival_station']['name'],
                'province_name' => $item['arrival_station']['province_name'],
                'district_name' => $item['arrival_station']['district_name'],
            ];
            $departure_station = [
                'name' => $item['departure_station']['name'],
                'province_name' => $item['departure_station']['province_name'],
                'district_name' => $item['departure_station']['district_name'],
            ];
            $seat_position = $item['seat_position'];
            return [
                'user' => $user,
                'seat_position' => $seat_position,
                'departure_station' => $departure_station,
                'arrival_station' => $arrival_station,
            ];
        }, $ticketsArr);
    }
}
