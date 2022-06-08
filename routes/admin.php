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
    // Route::get('/{user}', [PassengerController::class, 'show'])->name('show');
    // Route::delete('/{user}', [PassengerController::class, 'destroy'])->name('destroy');
});
