<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckRememberToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user')) {
            $remember_token = Cookie::get('remember_token');
            if ($remember_token != null) {
                $user = User::compareRememberToken($remember_token);
                if ($user !== null) {
                    $role = strtolower(UserRoleEnum::getKey($user->role));
                    User::setUserSession($user, $role);
                    if($role!=='passenger')
                        return redirect()->route($role.'.index');
                }
            }
        }
        return $next($request);
    }
}
