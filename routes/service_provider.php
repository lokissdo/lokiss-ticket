<?php

use App\Http\Controllers\ServiceProviderController;
use App\Http\Middleware\isStaff;
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
    'as' => 'serviceprovider.',
    'middleware' => [Loggedin::class, isStaff::class],
], function () {
        Route::get('/schedule/index', [ServiceProviderController::class, 'schedule_index'])->name('schedule.index');
        Route::get('/schedule/create', [ServiceProviderController::class, 'schedule_create'])->name('schedule.create');
        Route::post('/schedule/store', [ServiceProviderController::class, 'schedule_store'])->name('schedule.store');
        Route::delete('/schedule/destroy/{id}', [ServiceProviderController::class, 'schedule_destroy'])->name('schedule.destroy');


        Route::get('/coach/index', [ServiceProviderController::class, 'coach_index'])->name('coach.index');



       // Route::delete('/{user}', [PassengerController::class, 'destroy'])->name('destroy');
});
