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

}
