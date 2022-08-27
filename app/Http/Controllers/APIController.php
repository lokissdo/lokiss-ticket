<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoggedinRequest;
use App\Jobs\SendTicketMailJob;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\ServiceProvider;
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
        $fields=['address', 'address2', 'name', 'phone_number', 'email'];
        if(!$request->has($fields)) return  ['status' => -1,'message'=>'unvalid'];
        $user = User::isExist($request);
        if ($user === null) {
            try {
                $newUser = $request->only($fields);
                $temp = Str::random(8);
                $newUser['password'] = bcrypt($temp);
                $newUser['id'] = User::create($newUser)->id;
                $newUser['password'] = $temp;
            } catch (Exception $e) {
                return ['status' => -1,'message'=>$e->getMessage()];
            }
            $user_id = $newUser['id'];
        } else {
            $user_id = $user->id;
            if(!$user->phone_number) {
                $user->phone_number=$request->phone_number;
                $user->save();
            }
        }

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
        if ($user)
            return ['status' => 1];
        return ['status' => 1, 'user_password' => $newUser['password']];
    }
    public function infor_ratings(LoggedinRequest $req){
        if(!$req->trip_id) return ['status' => -1,'message'=>'Unvalid'];
        $infor=Rating::get_comments_by_user_and_trip($req->trip_id,session('user')['id']);
        return ['status' => 1,'data'=>$infor];
    }
    public function create_rating(LoggedinRequest $req){
        if(!$req->trip_id) return ['status' => -1,'message'=>'Unvalid'];
        $trip_id=$req->trip_id;
        $user_id=session('user')['id'];
        $isValidRate=Ticket::where('user_id',$user_id)->where('trip_id',$trip_id)->exists();
        if(!$isValidRate) return ['status' => -1,'message'=>'Unvalid'];
        $service_provider_id=Trip::find($trip_id)->service_provider_id;
        try{
            Rating::updateOrCreate(
                [
                    'user_id'=>$user_id,
                    'trip_id'=>$trip_id,
                    'service_provider_id'=>$service_provider_id
                ],
                ['comment'=>$req->comment,'rate'=>$req->rate]
            );
        }catch(Exception $e){
            return $e;
        }
       return 1;
    }
}
