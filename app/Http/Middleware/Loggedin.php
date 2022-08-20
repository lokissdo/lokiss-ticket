<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Loggedin
{

    public function handle(Request $request, Closure $next)
    {
        
        if (!$request->session()->has('user')) {
            return redirect()->route('login')->with(['message'=>'Vui lòng đăng nhập để tiếp tục!']);
        }
        return $next($request);
    }
}
