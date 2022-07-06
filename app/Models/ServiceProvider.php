<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
