<?php

namespace App\Http\Controllers;

use App\Jobs\SendTicketMailJob;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Ticket;
use App\Models\Trip;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class APIController extends Controller
{
    public function get_popular_schedules()
    {
        $data = Schedule::get_popular_schedule();
        return json_encode($data);
    }
    public function get_comments(Request $req)
    {
        return Rating::get_comments_by_service_provider($req->id)->toArray();
    }
    public function get_seats(Request $req)
    {
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
    public function create_ticket(Request $request)
    {
        $isExist = User::isExist($request);
        if ($isExist === null) {
            try {
                $newUser = $request->only(['address', 'address2', 'name', 'phone_number', 'email']);
                $temp = Str::random(8);
                $newUser['password'] = bcrypt($temp);
                $newUser['id'] = User::create($newUser)->id;
                $newUser['password'] = $temp;
            } catch (Exception $e) {
                return ['status' => -1,'message'=>$e->getMessage()];
            }
            $user_id = $newUser['id'];
        } else $user_id = $isExist->id;

        $tickets = [];
        for ($i = 0; $i < count($request->seat_position); $i++)
            $tickets[] = [
                'user_id' => $user_id,
                'trip_id' => $request->trip_id,
                'seat_position' => $request->seat_position[$i],
                'departure_station_id' => $request->departure_station_id,
                'arrival_station_id' => $request->arrival_station_id,
            ];
        try {
            Ticket::insert($tickets);
        } catch (Exception $e) {
            return  ['status' => -1,'message'=>$e->getMessage()];
        }

        $dispatchedData = $request->toArray();
        if (isset($newUser)) $dispatchedData['password'] = $newUser['password'];
        dispatch(new SendTicketMailJob($dispatchedData));
        if ($isExist)
            return ['status' => 1];
        return ['status' => 1, 'user_password' => $newUser['password']];
    }
}
