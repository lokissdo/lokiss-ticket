<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
        'arrival_station_id',
        'departure_station_id',
        'schedule_id',
        'trip_id',
        'user_id',
        'seat_position'
    ];
    public function arrival_station()
    {
        return $this->belongsTo(Station::class, 'arrival_station_id', 'id');
    }
    public function departure_station()
    {
        return $this->belongsTo(Station::class, 'departure_station_id', 'id');
    }
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    static function get_tickets(int $trip_id)
    {
        $tickets = Ticket::where('trip_id', $trip_id)->with([
            'user',
            'arrival_station.province',
            'arrival_station.district',
            'departure_station.province',
            'departure_station.district',
        ])->get();
        self::get_necessary_informations($tickets);
        $ticketsArr = $tickets->toArray();
        return $ticketsArr;
    }
    protected function get_necessary_informations($tickets)
    {
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
    public static function get_occupied_seats($trip_id)
    {
        return self::where('trip_id', $trip_id)->get('seat_position');
    }
    public static function get_tickets_by_user_id(int $user_id)
    {
        $tickets = Ticket::withTrashed()
            ->where('user_id', $user_id)
            ->with(['arrival_station.province', 'arrival_station.district', 'departure_station.province', 'departure_station.district'])
            ->with(['trip.schedule.departure_province', 'trip.schedule.arrival_province', 'trip.service_provider'])
            ->get();
        $ticketGroup = self::group_tickets_by_seats($tickets);
        return $ticketGroup;
    }
    public static function group_tickets_by_seats($ticketList)
    {
        $arr = [];
        foreach ($ticketList->toArray() as $ticket) {
            $key = $ticket['trip_id'] . '_' . strtotime($ticket['created_at']);
            if (empty($arr[$key])) {
                $temp = $ticket['seat_position'];
                $ticket['seat_position'] = array($temp);
                $arr[$key] = $ticket;
            } else $arr[$key]['seat_position'][] = $ticket['seat_position'];
        }
        return $arr;
    }
    public static function serviceprovider_total_tickets($service_provider_id)
    {
        return Cache::remember('total-tickets-' . $service_provider_id,3600, function ()use($service_provider_id) {
             return self::select(DB::raw('COUNT(*) AS total_tickets'))
                 ->join('trips', 'trips.id', '=', 'tickets.trip_id')->where('trips.service_provider_id', $service_provider_id)->first()->total_tickets;
        });
    }
    public static function delete_tickets($user_id,$trip_id,$created_at){
        
        return Ticket::where('user_id',$user_id)->where('trip_id',$trip_id)->where('created_at',$created_at)->update([
            'deleted_at' => now()
        ]);
    } 
}
