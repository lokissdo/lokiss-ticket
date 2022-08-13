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
        $tickets=Ticket::where('trip_id',$trip_id)->with([
            'user',
            'arrival_station.province',
            'arrival_station.district',
            'departure_station.province',
            'departure_station.district',
            ])->get();
        self::get_necessary_informations($tickets);
        $ticketsArr=$tickets->toArray();
        return $ticketsArr;
    }
    protected function get_necessary_informations($tickets){
        $tickets->map(function ($item) {
            $user = [
                'id' => $item->user_id,
                'name' => $item->user->name,
                'email' => $item->user->email,
                'avatar' => $item->user->avatar,
                'phone_number' => $item->user->phone_number,
            ];
            $item->arrival_station->append('province_name');
            $item->arrival_station->append('district_name');
            $item->departure_station->append('province_name');
            $item->departure_station->append('district_name');
            
            $seat_position = $item->seat_position;
            return collect([
                'user' => $user,
                'seat_position' => $seat_position,
                'departure_station' => $item->arrival_station,
                'arrival_station' => $item->departure_station,
            ]);
        });
    }
}
