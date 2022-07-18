<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScheduleRequest;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Google\Auth\Cache\Item;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
class ServiceProviderController extends Controller
{
    public function schedule_index(){
        View::share('title', 'Schedules');
        $schedules=Schedule::where('service_provider_id',session()->get('user')['service_provider_id'])->get();
        $schedules->append('departure_province');
        $schedules->append('arrival_province');
        $schedules->append('arrival_time_str');
        $schedules->append('departure_time_str');
        $schedules->append('total_days');

        return view("service_provider.schedule.index")->with([
            'schedules'=>$schedules->toArray()
            ]);
    }
    public function schedule_create()
    {
        View::share('title', 'ScheduleCreation');
        return view('service_provider.schedule.create');
    }
    public function schedule_store(CreateScheduleRequest $request)
    {
        $toInsert=$request->except('total_days','station_id');
        $toInsert['arrival_time']=$toInsert['arrival_time']+$request->total_days*1440;
        $toInsert['service_provider_id']=session()->get('user')['service_provider_id'];
        $schedule=Schedule::create($toInsert);
        if(!$schedule ) return 0;
        $schedules_detail=[];
        $arrStations=$request->station_id;
        $i=0;
        for(;$i<count($arrStations)-1;++$i){
            $schedules_detail[]=[
                'schedule_id'=>$schedule->id,
                'station_id'=>$arrStations[$i],
                'next_station_id'=>$arrStations[$i+1],
            ];
        }
        $schedules_detail[]=[
            'schedule_id'=>$schedule->id,
            'station_id'=>$arrStations[$i],
            'next_station_id'=>NULL,
        ];
        ScheduleDetail::insert($schedules_detail);
        return 1;
    }
    public function schedule_destroy(int $id){
        ScheduleDetail::where('schedule_id',$id)->delete();
        Schedule::find($id)->delete();
        return redirect()->route('serviceprovider.schedule.index'); 
    }
}
