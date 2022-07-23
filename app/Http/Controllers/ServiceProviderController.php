<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScheduleRequest;
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

    // Schedule
    public function schedule_index(){
        View::share('title', 'Schedules');

        //Schedule
        $schedules=Schedule::where('service_provider_id',session()->get('user')['service_provider_id'])->get();
        $schedules->append('departure_province');
        $schedules->append('arrival_province');
        $schedules->append('arrival_time_str');
        $schedules->append('departure_time_str');
        $schedules->append('total_days');

        // Schedule details
        $sche_ids = DB::table('schedules')
            ->select('id')
            ->where('schedules.service_provider_id',session()->get('user')['service_provider_id']);
        $list_stations=ScheduleDetail::joinSub($sche_ids, 'sche_ids', function ($join) {
            $join->on('schedule_details.schedule_id', '=', 'sche_ids.id');
        });
        $unordered_schedules=Station::joinSub($list_stations, 'list_stations', function ($join) {
            $join->on('stations.id', '=', 'list_stations.station_id');
        })->get()->toArray();
        $ordered_schedules=[];
        foreach($unordered_schedules as $each){
            $ordered_schedules[$each['id']][]=$each;
        }
        foreach($ordered_schedules as $key=>$each){
            $ordered_schedules[$key]=Station::OrderStations($each);
        }
        
        return view("service_provider.schedule.index")->with([
            'schedules'=>$schedules->toArray(),
            'schedule_details'=>$ordered_schedules,
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
        try{
            ScheduleDetail::where('schedule_id',$id)->delete();
            Schedule::find($id)->delete();
        }
        catch(Exception $e){
            return back()->withError('Không thể xóa lịch trình này vì đã được chọn trong chuyến đi');//$e->getMessage()
        }
        return redirect()->route('serviceprovider.schedule.index'); 
    }


    // Coach
    public function coach_index()
    {
        View::share('title', 'Coaches');
        $coaches=Coach::all();
        $coaches->append('type_name');
        return view('service_provider.coach.index',[
            'coaches'=>$coaches->toArray(),
        ]);
    }
}
