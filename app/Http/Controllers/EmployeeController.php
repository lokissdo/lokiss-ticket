<?php

namespace App\Http\Controllers;

use App\Models\EmployeesList;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $user=session('user');
        if(empty(session('user')['service_provider_id']) || empty(session('user')['service_provider_name']) ){
            $service_provider_id=EmployeesList::find($user['id'])->service_provider_id;
            $user['service_provider_id']=$service_provider_id;
            $user['service_provider_name']=ServiceProvider::find($service_provider_id)->name;
            session(['user' => $user]);
        }
       
       // View::share('title', 'Home');

        return redirect()->route('serviceprovider.index');
    }  
}
