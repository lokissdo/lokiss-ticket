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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'address2',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const UPDATED_AT = null;
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
    public function getAddressNameAttribute()
    {
        return  District::where('code',$this->address2)->first()->name.', '.Province::where('code', $this->address)->first()->name;
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
