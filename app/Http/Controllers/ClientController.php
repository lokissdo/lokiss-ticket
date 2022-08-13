<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
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
        $departure_province = Province::find($departure_province_code)->name??null;

        $arrival_province_code = $req->arrival_province_code;
        $arrival_province = Province::find($arrival_province_code)->name??null;

        $departure_date = $req->departure_date;
        $date = new DateTime($departure_date);
        $now = new DateTime();
        if (!$departure_province || !$arrival_province || $date < $now)
            return redirect()->route('passenger.index');

        $tripData = Trip::get_trips(null,$req,false);
        $trips=$tripData['trips'];
        $serviceProviderIdLists=Trip::get_service_provider_ids_list($trips);

        $scheduleIdLists=Trip::get_schedule_ids_list($trips);
        $scheduleDetails=ScheduleDetail::get_schedule_details($scheduleIdLists);
        $ratings=Rating::get_general_ratings_by_service_provider_list($serviceProviderIdLists);
        return view('client.trip')->with([
            'departure_province_code' => $departure_province_code,
            'departure_province' => $departure_province,
            'arrival_province_code' => $arrival_province_code,
            'arrival_province' => $arrival_province,
            'departure_date' => $departure_date,
            'trips' => $trips,
            'ratings'=>$ratings,
            'scheduleDetails'=>$scheduleDetails
        ]);
    }
    public function get_popular_schedules()
    {
        $data = Schedule::get_popular_schedule();
        return json_encode($data);
    }
}
