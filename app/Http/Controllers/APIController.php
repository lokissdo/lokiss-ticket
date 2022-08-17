<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Ticket;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class APIController extends Controller
{
    public function get_popular_schedules()
    {
        $data = Schedule::get_popular_schedule();
        return json_encode($data);
    }
    public function get_comments(Request $req){
        return Rating::get_comments_by_service_provider($req->id)->toArray();
    }
    public function get_seats(Request $req){
        // for($i=0;$i<=90000000;$i++);

        return Ticket::get_occupied_seats($req->trip_id)->toArray();
    }
    public function get_trips(Request $req)
    {
        $tripData = Trip::get_trips(null, $req, true);
        $trips = $tripData['trips'];

        $scheduleIdLists = Trip::get_schedule_ids_list($trips);
        $scheduleDetails = ScheduleDetail::get_schedule_details($scheduleIdLists);
        // for($i=0;$i<=90000000;$i++);
        if (isset($req->isAPI))
            return json_encode([
                'trips' => $trips,
                'scheduleDetails' => $scheduleDetails
            ]);
    }
}
