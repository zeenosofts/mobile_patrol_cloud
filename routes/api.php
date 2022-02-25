<?php

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

Route::get('/test', function () {
   dd("2");
});

Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'index'])->name('login');

//Route::post('/form',[\App\Http\Controllers\Api\LoginController::class,'form'])->name('form')->middleware('auth:api');

Route::middleware(['auth:api','cors'])->group(function () {
   // Route::post('/form',[\App\Http\Controllers\Api\LoginController::class,'form'])->name('form');
    Route::post('get_guard_schedules',[\App\Http\Controllers\Api\ScheduleController::class,'get_guard_schedules'])->name('get_guard_schedules');
    Route::post('create_guard_attendance',[\App\Http\Controllers\Api\AttendanceController::class,'save_guard_attendance'])->name('create_guard_attendance');
    Route::post('update_guard_attendance',[\App\Http\Controllers\Api\AttendanceController::class,'update_guard_attendance'])->name('update_guard_attendance');
    Route::post('check_guard_time_out',[\App\Http\Controllers\Api\AttendanceController::class,'check_guard_time_out'])->name('check_guard_time_out');
});
