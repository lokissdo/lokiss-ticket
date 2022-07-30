<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'address2',
        'avatar'
    ];
    const UPDATED_AT = null;
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
    ];
    public function province(){
        return $this->hasOne(Province::class,'code','address'); 
    }
    public function district(){
        return $this->hasOne(District::class,'code','address2'); 
    }
    public function getAddressNameAttribute()
    {
        return $this->district->name.', '.$this->province->name;
    }
    public function getRoleNameAttribute()
    {
        return  strtolower(UserRoleEnum::getKey($this->role));
    }


    
    static function createRememberToken($credentials)
    {
        return md5(strval($credentials['email']).strval($credentials['password'])).strval(time());
    }
    static function compareRememberToken($token)
    {
        $user=User::where('remember_token',$token)->first();
        return $user;
    }
    static function setUserSession($user,$role){
        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'role' => $role
        ]]);
    }
}
