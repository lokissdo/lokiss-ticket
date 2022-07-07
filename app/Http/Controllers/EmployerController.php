<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class EmployerController extends Controller
{
    public function index()
    {
        $user=session('user');
        $provider=ServiceProvider::where('employer_id',$user['id'])->first();
        $user['service_provider_id']=$provider->id;
        $user['service_provider_name']=$provider->name;

        session(['user' => $user]);
        View::share('title', 'Home');
        return view('employer.index');
    }    
    public function employee_index(Request $request)
    {
        View::share('title', 'Employer|Employees');
        $employees_list=ServiceProvider::getEmployeesList(session()->get('user')['service_provider_id']);
        return view('employer.employee.index')->with([
            'employees'=>$employees_list->toArray()
            ]);
    }
    public function employee_create(Request $request)
    {
        $employees_list=ServiceProvider::getEmployeesList(session()->get('user')['service_provider_id']);
        return view('employer.employee.index')->with([
            'employees'=>$employees_list->toArray()
            ]);
    }
}
