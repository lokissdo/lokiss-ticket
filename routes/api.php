<?php

use App\Http\Controllers\CoachController;
use App\Http\Controllers\StationController;
use App\Models\Addresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/addresses', [Addresses::class,'getDetailAddresses'])->name('addresses');
Route::get('/stations', [StationController::class,'getAllStations'])->name('stations');
Route::get('/coaches', [CoachController::class,'getCoaches'])->name('coaches');


