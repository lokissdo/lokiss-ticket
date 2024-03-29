<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Ticket;
use App\Models\Trip;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }
    public function trip(Request $req)
    {
        if (empty($req->departure_province_code) || empty($req->arrival_province_code) || empty($req->departure_date))
            return redirect()->route('passenger.index');
        $departure_province_code = $req->departure_province_code;
        $departure_province = Province::find($departure_province_code)->name ?? null;

        $arrival_province_code = $req->arrival_province_code;
        $arrival_province = Province::find($arrival_province_code)->name ?? null;

        $departure_date = $req->departure_date;
        $date = new DateTime($departure_date."23:59:59");
        $now = new DateTime();
        if (!$departure_province || !$arrival_province || ($date < $now))
            return redirect()->route('passenger.index');

        $tripData = Trip::get_trips(null, $req, true);
        $trips = $tripData['trips'];

        $scheduleIdLists = Trip::get_schedule_ids_list($trips);
        $scheduleDetails = ScheduleDetail::get_schedule_details($scheduleIdLists);
       
        return view('client.trip')->with([
            'departure_province_code' => $departure_province_code,
            'departure_province' => $departure_province,
            'arrival_province_code' => $arrival_province_code,
            'arrival_province' => $arrival_province,
            'departure_date' => $departure_date,
            'trips' => $trips,
            'scheduleDetails' => $scheduleDetails
        ]);
    }
    public function ticket(){
      $tickets=Ticket::get_tickets_by_user_id(session('user')['id']);
    //   $ticketsArray=array_map(function($item){
    //     return collect($item)->toArray();
    //   },$tickets);
    //   dd($ticketsArray);
    //dd($tickets);
        return view('client.ticket')->with(['tickets'=>$tickets]);
    }
}
