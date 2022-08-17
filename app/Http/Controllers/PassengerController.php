<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class PassengerController extends Controller
{
    public function index()
    {
        return view('client.index');
    }
   
}
