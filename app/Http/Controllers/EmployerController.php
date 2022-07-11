<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Events\AddEmployee;
use App\Events\DeleteEmployee;
use App\Http\Requests\AddEmployeeRequest;
use App\Models\EmployeesList;
use App\Models\ServiceProvider;
use App\Models\User;
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
    public function employee_index()
    {
        View::share('title', 'Employer|Employees');
        $employees_list=ServiceProvider::getEmployeesList(session()->get('user')['service_provider_id']);
        return view('employer.employee.index')->with([
            'employees'=>$employees_list->toArray()
            ]);
    }
    public function employee_create()
    {
        View::share('title', 'EmployeeCreation');
        return view('employer.employee.create');
    }
    public function employee_store(AddEmployeeRequest $request)
    {
        $toInsert=[];
        $toInsert['service_provider_id']=session()->get('user')['service_provider_id'];
        $user=User::where('email',$request->email)->first();
        $toInsert['id']=$user->id;
        $user->role=UserRoleEnum::EMPLOYEE;
        $user->save();
        return EmployeesList::create($toInsert);
    }
    public function employee_destroy(int $id)
    {
        EmployeesList::destroy($id);
        DeleteEmployee::dispatch($id);
        return redirect()->route('employer.employee.index'); 
    }
}
