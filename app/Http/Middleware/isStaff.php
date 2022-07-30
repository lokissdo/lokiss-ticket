<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class isStaff
{

    public function handle(Request $request, Closure $next)
    {
        $role=$request->session()->get('user')['role'];
        if ($role!='employee' && $role!='employer' ) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
