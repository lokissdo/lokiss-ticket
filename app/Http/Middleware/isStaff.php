<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class isStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $role=$request->session()->get('user')['role'];
        if ($role!='employee' && $role!='employer' ) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
