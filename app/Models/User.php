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

    protected $primaryKey = 'id';
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
    protected $casts = [];
    public function province()
    {
        return $this->hasOne(Province::class, 'code', 'address');
    }
    public function district()
    {
        return $this->hasOne(District::class, 'code', 'address2');
    }
    public function getAddressNameAttribute()
    {
        return $this->district->name . ', ' . $this->province->name;
    }
    public function getRoleNameAttribute()
    {
        return  strtolower(UserRoleEnum::getKey($this->role));
    }



    static function createRememberToken($credentials)
    {
        return md5(strval($credentials['email']) . strval($credentials['password'])) . strval(time());
    }
    static function compareRememberToken($token)
    {
        $user = User::where('remember_token', $token)->first();
        return $user;
    }
    static function setUserSession($user, $role)
    {
        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'role' => $role,
            'phone_number' => $user->phone_number,
            'address'=>$user->address,
            'address2'=>$user->address2,


        ]]);
    }
    static function get_user_with_filter_sort($searchCol, $searchVal, $sortCol, $sortType, $address, $address2, $role, $offset, $itemsPerPage, $includedTotalPage)
    {
        $query = User::where($searchCol, 'like', '%' . $searchVal . '%')
            ->orderBy($sortCol, $sortType);
        if ($address != 'null') {
            $query->where('address', $address);
            if ($address2 != 'null')  $query->where('address2', $address2);
        }
        if ($role != 'null')  $query->where('role', $role);

        $totalPage = ($includedTotalPage == 1) ? ceil(($query->count()) / $itemsPerPage) : -1;
        $users = $query->offset($offset)->limit($itemsPerPage)->with(['province', 'district'])->get();

        $users->append('address_name');
        $users->append('role_name');

        return [
            'totalPage' => $totalPage,
            'users' => $users
        ];
    }
}
