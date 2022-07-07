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
    public function getAddressNameAttribute()
    {
        return  Province::where('code', $this->address)->first()->name;
    }
    public function getEmailAttribute()
    {
        return  User::find($this->employer_id)->email;
    }
    static function getEmployeesList($id)
    {
        $ids = DB::table('employees_list')
        ->select('id')
        ->where('employees_list.service_provider_id', $id);
      $employees_list=User::joinSub($ids, 'employee_ids', function ($join) {
            $join->on('users.id', '=', 'employee_ids.id');
        })
        ->get();
        $employees_list->append('address_name');
        return $employees_list;
    }
}
