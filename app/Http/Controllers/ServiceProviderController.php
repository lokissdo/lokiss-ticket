<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\TripRegisteringRequest;
use App\Models\Coach;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\ServiceProvider;
use App\Models\Station;
use App\Models\Ticket;
use App\Models\Trip;
use Exception;
use Google\Auth\Cache\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class ServiceProviderController extends Controller
{

    private $service_provider_id;
    public function __construct()
    {
        if (session()->has('user'))
            $this->service_provider_id = session()->get('user')['service_provider_id'];
    }
    // Schedule
    public function schedule_index()
    {
        View::share('title', 'Schedules');

        //Schedule
        $schedules = ServiceProvider::get_schedules_list($this->service_provider_id);
        return view("service_provider.schedule.index")->with([
            'schedules' => $schedules,
        ]);
    }
    public function schedule_show(int $id)
    {
        View::share('title', 'Schedules');
        //Schedule
        $schedule = ServiceProvider::get_schedules_list($this->service_provider_id, $id)[0];
        return view("service_provider.schedule.show")->with([
            'schedule' => $schedule,
        ]);
    }
    public function schedule_create()
    {
        View::share('title', 'ScheduleCreation');
        return view('service_provider.schedule.create');
    }
    public function schedule_store(CreateScheduleRequest $request)
    {
        $toInsert = $request->except('total_days', 'station_id');
        $toInsert['arrival_time'] = $toInsert['arrival_time'] + $request->total_days * 1440;
        $toInsert['service_provider_id'] = $this->service_provider_id;
        $schedule = Schedule::create($toInsert);
        if (!$schedule) return 0;
        $schedules_detail = [];
        $arrStations = $request->station_id;
        $i = 0;
        for (; $i < count($arrStations) - 1; ++$i) {
            $schedules_detail[] = [
                'schedule_id' => $schedule->id,
                'station_id' => $arrStations[$i],
                'next_station_id' => $arrStations[$i + 1],
            ];
        }
        $schedules_detail[] = [
            'schedule_id' => $schedule->id,
            'station_id' => $arrStations[$i],
            'next_station_id' => NULL,
        ];
        ScheduleDetail::insert($schedules_detail);
        return 1;
    }
    public function schedule_destroy(int $id)
    {
        try {
            ScheduleDetail::where('schedule_id', $id)->delete();
            Schedule::find($id)->delete();
        } catch (Exception $e) {
            return back()->withError('Không thể xóa lịch trình này vì đã được chọn trong chuyến đi'); //$e->getMessage()
        }
        return redirect()->route('serviceprovider.schedule.index');
    }



    // Coach
    public function coach_index()
    {
        View::share('title', 'Coaches');
        $coaches = Coach::where('service_provider_id', $this->service_provider_id)->get();
        $coaches->append('type_name');
        return view('service_provider.coach.index', [
            'coaches' => $coaches->toArray(),
        ]);
    }


    //trip
    public function trip_index()
    {
        View::share('title', 'Trip');
        $trips = Trip::get_trips($this->service_provider_id);
        return view('service_provider.trip.index')->with(['trips' => $trips]);
    }
    public function trip_create(int $id)
    {
        if (empty(Schedule::find($id)) || Schedule::find($id)->service_provider_id != $this->service_provider_id)
            return back()->withError('Bạn không có quyền truy cập vào trang này');
        View::share('title', 'TripCreation');
        return view('service_provider.trip.create', ['id' => $id]);
    }
    public function trip_store(TripRegisteringRequest $request)
    {
        $newTrip = $request->toArray();
        $newTrip['service_provider_id'] = $this->service_provider_id;
        return Trip::create($newTrip);
    }
    public function trip_destroy(int $id)
    {
        try {
            Trip::find($id)->delete();
        } catch (Exception $e) {
            return back()->withError('Không thể xóa chuyến đi này vì đã có người mua vé'); //$e->getMessage()
        }
        return redirect()->route('serviceprovider.trip.index');
    }
    public function trip_show(int $id)
    {
        View::share('title', 'Trip');
        //Schedule
        $trip = Trip::get_trips($this->service_provider_id, $id)[0];
        $schedule = ServiceProvider::get_schedules_list($this->service_provider_id, $trip['schedule_id'])[0];
        $tickets = Ticket::get_tickets($id);
        $tickets = array_map(function ($item) {
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
        }, $tickets);
        return view("service_provider.trip.show")->with([
            'schedule' => $schedule,
            'tickets' => $tickets,
            'trip' => $trip,
        ]);
    }
}
