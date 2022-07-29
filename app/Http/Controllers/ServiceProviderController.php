<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\TripRegisteringRequest;
use App\Models\Coach;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Station;
use Exception;
use Google\Auth\Cache\Item;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ServiceProviderController extends Controller
{

    private $service_provider_id;
    public function __construct()
    {
        $this->service_provider_id = session()->get('user')['service_provider_id'];
    }
    // Schedule
    public function schedule_index()
    {
        View::share('title', 'Schedules');

        //Schedule
        $schedules = Schedule::where('service_provider_id', $this->service_provider_id)->with(['schedule_detail.station'])->get();
        $schedules->append('departure_province_name');
        $schedules->append('arrival_province_name');
        $schedules->append('arrival_time_str');
        $schedules->append('departure_time_str');
        $schedules->append('total_days');
        $schedules->makeHidden([
            'arrival_province', 'departure_province',
            'departure_province_code', 'arrival_province_code', 'departure_time', 'arrival_time'
        ]);


        $schedules = $schedules->toArray();
        $schedules = array_map(function ($each) {
            $each['schedule_detail'] = Station::OrderStations($each['schedule_detail']);
            $TrimmedDetail = [];
            foreach ($each['schedule_detail'] as $temp) {
                $TrimmedDetail[] =
                    [
                        'name' => $temp['station']['name'],
                        'province_name' => $temp['station']['province_name'],
                        'district_name' => $temp['station']['district_name'],
                    ];
            }
            $each['schedule_detail'] = $TrimmedDetail;
            return $each;
        }, $schedules);

        
        return view("service_provider.schedule.index")->with([
            'schedules' => $schedules,
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
        return view('service_provider.trip.index');
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
    }
}
