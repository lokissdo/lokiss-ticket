<?php

use App\Http\Controllers\PassengerController;
use App\Http\Middleware\isPassenger;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Loggedin;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'as' => 'passenger.',
    'middleware' => [Loggedin::class,isPassenger::class],
], function () {
    Route::get('/', [PassengerController::class, 'index'])->name('index');
    // Route::get('/{user}', [PassengerController::class, 'show'])->name('show');
    // Route::delete('/{user}', [PassengerController::class, 'destroy'])->name('destroy');
});
