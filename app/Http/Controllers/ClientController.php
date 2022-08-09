<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    public function index(){
        return view('client.index');
    }
    public function trip(){
        return view('client.trip');
    }
    public function get_popular_schedules(){
        $data=Schedule::get_popular_schedule();
        return json_encode( $data);
    }
}
