<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Events\UserRegisteredEvent;
use App\Http\Requests\AuthenticatingRequest;
use App\Http\Requests\RegisteringRequest;
use App\Mail\NotifyMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use App\Jobs\SendEmailJob as Job;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
const DEFAULT_ROLE=1;
class AuthController extends Controller
{
    public function login()
    {
        if(session()->has('user')){
            return redirect()->route(session('user')['role'].'.index');
        }
        View::share('title', 'Đăng nhập');
        return view('auth/login');
    }

    public function register()
    {
        View::share('title', 'Đăng ký');
        return view('auth/register');
    }
    public function registering(RegisteringRequest $request)
    {
        $toInsert=$request->validated();
        $toInsert['password']= bcrypt($toInsert['password']);
        $user = User::create($toInsert);
        dispatch(new Job($user));
        //$email = new NotifyMail($user);
       // Mail::to($user->email)->send($email);
        $request->session()->flash('message', 'Successfully registered.');
        return redirect()->route("login");
    }
    public function callback($provider)
    {

        $data = Socialite::driver($provider)->user();

        $user = User::query()
            ->where('email', $data->getEmail())
            ->first();
        $toDispatch=0;
        if (is_null($user)) {
            $user = new User();
            $toDispatch=1;
        }
        $user->email = $data->getEmail();
        $user->name   = $data->getName();
        $user->avatar = $data->getAvatar();
        $user->save();
        if(!$user->email) return redirect()->route("register",[
            'error'=>"Your account doesn't include email"
        ]);
        $roleIndex=is_null($user->role)?DEFAULT_ROLE:$user->role;
        $role = strtolower(UserRoleEnum::getKeys($roleIndex)[0]);
        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'role' => $role
        ]]);
       if($toDispatch) dispatch(new Job($user));
        return redirect()->route("$role.index");
    }
    public function loggingIn(AuthenticatingRequest $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $roleName = strtolower(UserRoleEnum::getKeys($user->role)[0]);
            session(['user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $roleName
            ]]);
            return redirect()->route("$roleName.index");
        }
        return Redirect::back()->withErrors(['Email or password is incorrect.',]);
    }
}
