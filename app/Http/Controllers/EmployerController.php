<?php

namespace App\Http\Controllers;

use App\Enums\CoachTypesEnum;
use App\Enums\UserRoleEnum;
use App\Events\DeleteEmployee;
use App\Http\Requests\AddEmployeeRequest;
use App\Http\Requests\CoachRegisteringRequest;
use App\Models\Coach;
use App\Models\EmployeesList;
use App\Models\ServiceProvider;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class EmployerController extends Controller
{
    private $service_provider_id;
    public function __construct()
    {
        if (session()->has('user'))
            $this->service_provider_id = session()->get('user')['service_provider_id'] ?? null;
    }
    public function index()
    {
        $user = session('user');
        if(empty(session('user')['service_provider_id']) || empty(session('user')['service_provider_name']) ){
            $provider = ServiceProvider::where('employer_id', $user['id'])->first();
            $user['service_provider_id'] = $provider->id;
            $user['service_provider_name'] = $provider->name;
            session(['user' => $user]);
        }     
        return redirect()->route('serviceprovider.index');

    }
    public function employee_index()
    {
        View::share('title', 'Employees');

        return view('employer.employee.index')->with([
            'employees' => EmployeesList::get_employees_list($this->service_provider_id)
        ]);
    }
    public function employee_create()
    {
        View::share('title', 'EmployeeCreation');
        return view('employer.employee.create');
    }
    public function employee_store(AddEmployeeRequest $request)
    {
        $toInsert = [];
        $toInsert['service_provider_id'] = $this->service_provider_id;
        $user = User::where('email', $request->email)->first();
        $toInsert['id'] = $user->id;
        $user->role = UserRoleEnum::EMPLOYEE;
        $user->save();
        return EmployeesList::create($toInsert);
    }
    public function employee_destroy(int $id)
    {
        try {
            EmployeesList::destroy($id);
            DeleteEmployee::dispatch($id);
        } catch (Exception $e) {
            return back()->withError('Cần phải xóa các hoạt động của nhân viên này trước');
        }
        return redirect()->route('employer.employee.index');
    }



    public function coach_create()
    {
        View::share('title', 'CoachCreation');
        $coachTypes = CoachTypesEnum::asArray();
        return view('employer.coach.create', [
            'coach_types' => $coachTypes,
        ]);
    }
    public function coach_store(CoachRegisteringRequest $request)
    {
        $toInsert = $request->only('seat_number', 'name', 'type');
        $toInsert['service_provider_id'] = $this->service_provider_id;

        try {
            $dirName = 'public/img/provider/' . $toInsert['service_provider_id'];
            $pathPhoto = substr($request->file('photo')->store($dirName), strlen('public/img/'));
            $toInsert['photo'] = $pathPhoto;
            Coach::create($toInsert);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return redirect()->route('serviceprovider.coach.index');
    }
    public function coach_destroy($id)
    {
        try {
            $coach=Coach::find($id);
            Storage::delete('public/img/'.$coach->photo);
            $coach->delete();
        } catch (Exception $e) {
            return back()->withError('Phải xóa các chuyến đi trước đó có sử dụng xe này'); //$e->getMessage()
        }
        return redirect()->route('serviceprovider.coach.index');
    }
}
