<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeesList extends Model
{
    use HasFactory;
    protected $table = 'employees_list';
    protected $fillable = [
        'id',
        'service_provider_id',
    ];
    const UPDATED_AT = null;
    public function user(){
        return $this->hasOne(User::class,'id','id'); 
    }
    static function get_employees_list($service_provider_id)
    {
        if (session()->get('user')['role'] != 'employer') return null;
        $employees = self::where('service_provider_id', $service_provider_id)->with(['user.province', 'user.district'])->get();
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
}
