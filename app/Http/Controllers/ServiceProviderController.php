<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
class ServiceProviderController extends Controller
{
    public function schedule_index(){
        View::share('title', 'Schedules');
        $schedules=Schedule::where('service_provider_id',session()->get('user')['service_provider_id'])->get();
        $schedules->append('departure_province');
        $schedules->append('arrival_province');
        return view("service_provider.schedule.index")->with([
            'schedules'=>$schedules->toArray()
            ]);;
    }
    public function schedule_create()
    {
        View::share('title', 'ScheduleCreation');
        return view('service_provider.schedule.create');
    }
}
