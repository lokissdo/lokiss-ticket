<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Events\UserRegisteredEvent;
use App\Http\Requests\RegisteringRequest;
use App\Mail\NotifyMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Jobs\SendEmailJob as Job;
const DEFAULT_ROLE=0;
class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }
    public function registering(RegisteringRequest $request)
    {
        $toInsert=$request->validated();
        $toInsert['password']= bcrypt($toInsert['password']);
        $user = User::create($toInsert);
        Job::dispatch(new Job($user));
        return view('auth/login');
    }
    public function callback($provider)
    {

        $data = Socialite::driver($provider)->user();

        $user = User::query()
            ->where('email', $data->getEmail())
            ->first();
        if (is_null($user)) $user = new User();
        $user->email = $data->getEmail();
        $user->name   = $data->getName();
        $user->avatar = $data->getAvatar();
        $user->save();
        if(!$user->email) return redirect()->route("register",[
            'error'=>"Your account doesn't include email"
        ]);
        $roleIndex=is_null($user->role)?DEFAULT_ROLE:$user->role;
        $role = strtolower(UserRoleEnum::getKeys($roleIndex)[0]);
        // Auth::attempt([
        //     'email' => $user->email,
        //     'password' => $user->password
        // ]);
        return redirect()->route("$role.index");
    }
}
