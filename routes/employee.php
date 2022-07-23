<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\isEmployee;
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
    'as' => 'employee.',
    'middleware' => [Loggedin::class,isEmPloyee::class],
], function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    // Route::get('/employee', [EmployeeController::class, 'employee_index'])->name('employee.index');
    // Route::get('/employee/create', [EmployeeController::class, 'employee_create'])->name('employee.create');
    // Route::delete('/employee/destroy/{id}', [EmployeeController::class, 'employee_destroy'])->name('employee.destroy');
    // Route::post('/employee/store', [EmployeeController::class, 'employee_store'])->name('employee.store');


    // Route::get('/coach/create', [EmployeeController::class, 'coach_create'])->name('coach.create');
    // Route::post('/coach/store', [EmployeeController::class, 'coach_store'])->name('coach.store');
    // Route::delete('/coach/destroy/{id}', [EmployeeController::class, 'coach_destroy'])->name('coach.destroy');
    // Route::get('/employee/edit/{id}', [EmployeeController::class, 'employee_edit'])->name('employee.edit');
    // Route::post('/employee/update/{id}', [EmployeeController::class, 'employee_update'])->name('employee.update');

});
