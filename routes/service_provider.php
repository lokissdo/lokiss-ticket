<?php

use App\Http\Controllers\service_provider\SP_CoachController;
use App\Http\Controllers\service_provider\SP_IndexController;
use App\Http\Controllers\service_provider\SP_ScheduleController;
use App\Http\Controllers\service_provider\SP_TripController;
use App\Http\Middleware\isStaff;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Loggedin;


Route::group([
    'as' => 'serviceprovider.',
    'middleware' => [Loggedin::class, isStaff::class],
], function () {
    Route::get('/index', [SP_IndexController::class, 'index'])->name('index');

        Route::get('/schedule/index', [SP_ScheduleController::class, 'schedule_index'])->name('schedule.index');
        Route::get('/schedule/create', [SP_ScheduleController::class, 'schedule_create'])->name('schedule.create');
        Route::post('/schedule/store', [SP_ScheduleController::class, 'schedule_store'])->name('schedule.store');
        Route::get('/schedule/show/{id}', [SP_ScheduleController::class, 'schedule_show'])->name('schedule.show');
        Route::delete('/schedule/destroy/{id}', [SP_ScheduleController::class, 'schedule_destroy'])->name('schedule.destroy');
        Route::get('/schedule/export', [SP_ScheduleController::class, 'schedule_export'])->name('schedule.export');




    Route::get('/coach/index', [SP_CoachController::class, 'coach_index'])->name('coach.index');
    Route::get('/coach/export', [SP_CoachController::class, 'coach_export'])->name('coach.export');

    Route::get('/trip/export/byseat/{id}', [SP_TripController::class, 'trip_export_byseat'])->name('trip.export_byseat');
    Route::get('/trip/export/bystation/{id}', [SP_TripController::class, 'trip_export_bystation'])->name('trip.export_bystation');

        Route::get('/trip/index', [SP_TripController::class, 'trip_index'])->name('trip.index');
        Route::get('/trip/create/{id}', [SP_TripController::class, 'trip_create'])->name('trip.create');
        Route::post('/trip/store', [SP_TripController::class, 'trip_store'])->name('trip.store');
        Route::delete('/trip/destroy/{id}', [SP_TripController::class, 'trip_destroy'])->name('trip.destroy');
        Route::get('/trip/show/{id}', [SP_TripController::class, 'trip_show'])->name('trip.show');
        Route::get('/trip/import', [SP_TripController::class, 'trip_import'])->name('trip.import');
        Route::post('/trip/import', [SP_TripController::class, 'trip_importing'])->name('trip.importing');



       // Route::delete('/{user}', [PassengerController::class, 'destroy'])->name('destroy');
});
