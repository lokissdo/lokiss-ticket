<?php

use App\Http\Controllers\EmployerController;
use App\Http\Middleware\isEmPloyer;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Loggedin;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceemployee within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'as' => 'employer.',
    'middleware' => [Loggedin::class,isEmPloyer::class],
], function () {
    Route::get('/', [EmployerController::class, 'index'])->name('index');
    Route::get('/employee', [EmployerController::class, 'employee_index'])->name('employee.index');
    Route::get('/employee/create', [EmployerController::class, 'employee_create'])->name('employee.create');
    Route::delete('/employee/destroy/{id}', [EmployerController::class, 'employee_destroy'])->name('employee.destroy');
    Route::post('/employee/store', [EmployerController::class, 'employee_store'])->name('employee.store');


    Route::get('/coach/create', [EmployerController::class, 'coach_create'])->name('coach.create');
    Route::post('/coach/store', [EmployerController::class, 'coach_store'])->name('coach.store');
    Route::delete('/coach/destroy/{id}', [EmployerController::class, 'coach_destroy'])->name('coach.destroy');
    // Route::get('/employee/edit/{id}', [EmployerController::class, 'employee_edit'])->name('employee.edit');
    // Route::post('/employee/update/{id}', [EmployerController::class, 'employee_update'])->name('employee.update');

});
