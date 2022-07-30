<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Enums\UserRoleEnum;

class ServiceProvider extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'employer_id',
        'rate'
    ];
    const UPDATED_AT = null;

    public function employer()
    {
        return $this->hasOne(User::class, 'id', 'employer_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'address', 'code');
    }
    public function getAddressNameAttribute()
    {
        return $this->province->name;
    }
    public function getEmailAttribute()
    {
        return  $this->employer->email;
    }
    public function employees()
    {
        return $this->hasMany(EmployeesList::class, 'service_provider_id', 'id');
    }
    static function get_employees_list($service_provider_id)
    {
        if(session()->get('user')['role']!='employer') return null;
        $serviceProvider = ServiceProvider::where('id', $service_provider_id)->with(['employees.user.province', 'employees.user.district'])->first();
        $employees = $serviceProvider->employees;
        $employeesArrray = [];
        foreach ($employees as $item) {
            $item->user->append('address_name');
            $employeesArrray[] = [
                'id' => $item->user->id,
                'name' => $item->user->name,
                'email' => $item->user->email,
                'address_name' => $item->user->address_name,
                'created_at' => $item->created_at
            ];
        }
        return $employeesArrray;
    }
    
    static function get_schedules_list($service_provider_id,$schedule_id=null){
        $query=Schedule::where('service_provider_id', $service_provider_id);
        if($schedule_id!=-null) $query=$query->where('id', $schedule_id);
        $schedules = $query->with(['schedule_detail.station'])->get();
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
        return $schedules;
    }
}
