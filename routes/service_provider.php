<?php

use App\Http\Controllers\ServiceProviderController;
use App\Http\Middleware\isStaff;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Loggedin;


Route::group([
    'as' => 'serviceprovider.',
    'middleware' => [Loggedin::class, isStaff::class],
], function () {
        Route::get('/schedule/index', [ServiceProviderController::class, 'schedule_index'])->name('schedule.index');
        Route::get('/schedule/create', [ServiceProviderController::class, 'schedule_create'])->name('schedule.create');
        Route::post('/schedule/store', [ServiceProviderController::class, 'schedule_store'])->name('schedule.store');
        Route::get('/schedule/show/{id}', [ServiceProviderController::class, 'schedule_show'])->name('schedule.show');
        Route::delete('/schedule/destroy/{id}', [ServiceProviderController::class, 'schedule_destroy'])->name('schedule.destroy');


        Route::get('/coach/index', [ServiceProviderController::class, 'coach_index'])->name('coach.index');
        Route::get('/trip/index', [ServiceProviderController::class, 'trip_index'])->name('trip.index');
        Route::get('/trip/create/{id}', [ServiceProviderController::class, 'trip_create'])->name('trip.create');
        Route::post('/trip/store', [ServiceProviderController::class, 'trip_store'])->name('trip.store');
        Route::delete('/trip/destroy/{id}', [ServiceProviderController::class, 'trip_destroy'])->name('trip.destroy');
        Route::get('/trip/show/{id}', [ServiceProviderController::class, 'trip_show'])->name('trip.show');




       // Route::delete('/{user}', [PassengerController::class, 'destroy'])->name('destroy');
});
