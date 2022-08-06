<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PassengerController;
use App\Http\Middleware\CheckRememberToken;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Middleware\isPassenger;
use App\Http\Middleware\Loggedin;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('layout.master');
// })->name('welcome');

Route::group([
    'middleware' => [CheckRememberToken::class],
], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
});



Route::post('/login', [AuthController::class, 'loggingIn'])->name('loggingIn');
Route::get('/signout', [AuthController::class, 'signOut'])->name('signOut');

Route::post('/register', [AuthController::class, 'registering'])->name('registering');
Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('social.redirect');
Route::get('/auth/callback/{provider}',  [AuthController::class, 'callback'])->name('social.callback');



Route::group([
    'as' => 'passenger.',
    'middleware' => [Loggedin::class,isPassenger::class],
], function () {
    Route::get('/', [PassengerController::class, 'index'])->name('index');
    // Route::get('/{user}', [PassengerController::class, 'show'])->name('show');
    // Route::delete('/{user}', [PassengerController::class, 'destroy'])->name('destroy');
});
