<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\isAdmin;
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
    'as' => 'admin.',
    'middleware' => [Loggedin::class,isAdmin::class],
], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/provider', [AdminController::class, 'provider_index'])->name('provider.index');
    Route::get('/provider/create', [AdminController::class, 'provider_create'])->name('provider.create');
    Route::post('/provider/store', [AdminController::class, 'provider_store'])->name('provider.store');
    Route::get('/provider/edit/{id}', [AdminController::class, 'provider_edit'])->name('provider.edit');
    Route::post('/provider/update/{id}', [AdminController::class, 'provider_update'])->name('provider.update');
    Route::delete('/provider/destroy/{id}', [AdminController::class, 'provider_destroy'])->name('provider.destroy');


    Route::get('/station', [AdminController::class, 'station_index'])->name('station.index');
    Route::get('/station/create', [AdminController::class, 'station_create'])->name('station.create');
    Route::post('/station/store', [AdminController::class, 'station_store'])->name('station.store');
    Route::delete('/station/destroy/{id}', [AdminController::class, 'station_destroy'])->name('station.destroy');

    Route::get('/user', [AdminController::class, 'user_index'])->name('user.index');

    // Route::get('/{user}', [userController::class, 'show'])->name('show');
    // Route::delete('/{user}', [userController::class, 'destroy'])->name('destroy');
});
