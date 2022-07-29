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
    public function getEmailAttribute()
    {
        return  $this->employer->email;
    }
    public function employees_list()
    {
        return $this->hasMany(EmployeesList::class, 'id', 'employer_id');
    }
    static function getEmployeesList($id)
    {
        $ids = DB::table('employees_list')
            ->select('id')
            ->where('employees_list.service_provider_id', $id);
        $employees_list = User::joinSub($ids, 'employee_ids', function ($join) {
            $join->on('users.id', '=', 'employee_ids.id');
        })->with(['province'])->get();
        $employees_list->append('address_name');
        return $employees_list;
    }
}
