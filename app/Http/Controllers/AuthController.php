<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\AuthenticatingRequest;
use App\Http\Requests\RegisteringRequest;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Jobs\SendEmailJob as Job;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    private const DEFAULT_ROLE = 1;
    
    public function login()
    {
        // if (Auth::viaRemember()) {
        //     dd(Auth::user());
        // }
       
        if (session()->has('user')) {
            return redirect()->route(session('user')['role'] . '.index');
        }
        View::share('title', 'Đăng nhập');
        return view('auth/login');
    }
    public function signOut()
    {
        try{
            $role=session('user')['role'];
        }catch(Exception $e){
            return redirect()->route("passenger.index");
        }  
        session()->flush();
        Cookie::queue(Cookie::forget('remember_token'));
        if($role=='passenger')  return redirect()->route("passenger.index");

        return redirect()->route("login");
    }
    public function register()
    {
        View::share('title', 'Đăng ký');
        return view('auth/register');
    }
    public function registering(RegisteringRequest $request)
    {
        $toInsert = $request->validated();
        $toInsert['password'] = bcrypt($toInsert['password']);
        $user = User::create($toInsert);
        dispatch(new Job($user));
        //$email = new NotifyMail($user);
        // Mail::to($user->email)->send($email);
        session()->flash('message', 'Successfully registered.');
        return redirect()->route("login");
    }
    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();
        $user = User::query()
            ->where('email', $data->getEmail())
            ->first();
        $toDispatch = 0;
        if (is_null($user)) {
            $user = new User();
            $toDispatch = 1;
        }
        $user->email = $data->getEmail();
        $user->name   = $data->getName();
        $user->avatar = $data->getAvatar();
        $user->save();
        if (!$user->email) return redirect()->route("register", [
            'error' => "Your account doesn't include email"
        ]);
        $roleIndex = is_null($user->role) ? self::DEFAULT_ROLE : $user->role;
        $role = strtolower(UserRoleEnum::getKey($roleIndex));
        User::setUserSession($user, $role);
        if ($toDispatch) dispatch(new Job($user));
        return redirect()->route("$role.index");
    }

    public function loggingIn(AuthenticatingRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $roleName = strtolower(UserRoleEnum::getKey($user->role));
            User::setUserSession($user, $roleName);
            if (isset($request->isRemembered)) {
                $remember_token = User::createRememberToken($credentials);
                Cookie::queue('remember_token',$remember_token, time() + 86400 * 30);
                $user->remember_token=$remember_token;
                $user->save();
            }
            return redirect()->route("$roleName.index");
        }
        return Redirect::back()->withErrors(['Email or password is incorrect.',]);
    }
}
