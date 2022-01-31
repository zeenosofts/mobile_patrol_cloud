<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    #------------------------- Admin Accounts Methods ----------------#
    Route::get('/accounts/manager/create', [App\Http\Controllers\AccountsController::class, 'index'])
        ->name('create_manager_account')->middleware('role:super_admin');
    Route::post('/accounts/manager/save', [App\Http\Controllers\AccountsController::class, 'save_manager_account'])
        ->name('save_manager_account')->middleware('role:super_admin');
    Route::get('/accounts/manager/manage', [App\Http\Controllers\AccountsController::class, 'manage_manager_account'])
        ->name('manage_manager_account')->middleware('role:super_admin');
    #------------------------ Manager Accounts Methods----------------#
    Route::get('/manager/company/setting', [App\Http\Controllers\Setting\CompanySettingController::class, 'manager_company_setting'])
        ->name('manager_company_setting')->middleware('role:manager');
    Route::post('save_company_details', [App\Http\Controllers\Setting\CompanySettingController::class, 'save_company_details'])
        ->name('save_company_details')->middleware('role:manager');
    #------------------------ Manager Accounts---Guard Module Methods----------------#
    Route::get('manager/create/guard', [App\Http\Controllers\Manager\GuardController::class, 'create_guard'])
        ->name('create_guard')->middleware('role:manager');
    Route::post('manager/create/guard/save', [App\Http\Controllers\Manager\GuardController::class, 'save_guard'])
        ->name('save_guard')->middleware('role:manager');
    Route::get('manager/manage/guard', [App\Http\Controllers\Manager\GuardController::class, 'manage_guard'])
        ->name('manage_guard')->middleware('role:manager'); //
    Route::get('manager/edit/guard/{guard_id}/{hash}', [App\Http\Controllers\Manager\GuardController::class, 'edit_guard'])
        ->name('edit_guard')->middleware('role:manager');
    Route::post('manager/update/guard', [App\Http\Controllers\Manager\GuardController::class, 'update_guard'])
        ->name('update_guard')->middleware('role:manager');//
    Route::post('change_status', [App\Http\Controllers\Manager\GuardController::class, 'change_status'])
        ->name('change_status')->middleware('role:manager');

    #------------------------ Manager Accounts---Client Module Methods----------------# client_checkpoints
    Route::get('manager/create/client', [App\Http\Controllers\Manager\ClientController::class, 'create_client'])
        ->name('create_client')->middleware('role:manager');
    Route::post('manager/create/client/save', [App\Http\Controllers\Manager\ClientController::class, 'save_client'])
        ->name('save_client')->middleware('role:manager');
    Route::get('manager/manage/client', [App\Http\Controllers\Manager\ClientController::class, 'manage_clients'])
        ->name('manage_clients')->middleware('role:manager'); //
    Route::get('manager/edit/client/{client_id}/{hash}', [App\Http\Controllers\Manager\ClientController::class, 'edit_client'])
        ->name('edit_client')->middleware('role:manager');
    Route::post('manager/update/client', [App\Http\Controllers\Manager\ClientController::class, 'update_client'])
        ->name('update_client')->middleware('role:manager');

    #------------------------ Manager Accounts---Client Checkpoints Methods----------------#
    Route::get('manager/client/checkpoint/{client_id}/{hash}', [App\Http\Controllers\Manager\CheckpointController::class, 'client_checkpoints'])
        ->name('client_checkpoints')->middleware('role:manager');
    Route::post('manager/create/checkpoint/qr', [App\Http\Controllers\Manager\CheckpointController::class, 'create_qr_checkpoint'])
        ->name('create_qr_checkpoint')->middleware('role:manager');
    #------------------------ Manager Accounts---Client Schedule Methods----------------#
    Route::get('manager/schedule/{any?}', [App\Http\Controllers\Manager\ScheduleController::class, 'index'])
        ->name('schedule')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::post('save_schedule', [App\Http\Controllers\Manager\ScheduleController::class, 'save_schedule'])
        ->name('save_schedule')->middleware('role:manager');
    Route::post('get_schedules_for_guard', [App\Http\Controllers\Manager\ScheduleController::class, 'get_schedules_for_guard'])
        ->name('get_schedules_for_guard')->middleware('role:manager');
    Route::post('update_schedule', [App\Http\Controllers\Manager\ScheduleController::class, 'update_schedule'])
        ->name('update_schedule')->middleware('role:manager');

    #------------------------Manager Accounts ----------Create Dynamic formbuilder----------------#
    Route::get('manager/form/{any?}', [App\Http\Controllers\FormController::class, 'index'])
        ->name('form')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::post('save_form', [App\Http\Controllers\FormController::class, 'save_form'])
        ->name('save_form')->middleware('role:manager');
    Route::get('manager/manage/form', [App\Http\Controllers\FormController::class, 'manage_form'])
        ->name('manage_form')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::get('manager/form/edit/{id}/{hash}', [App\Http\Controllers\FormController::class, 'index'])
        ->name('edit_form')->middleware('role:manager');
    Route::get('manager/get/form/{id}', [App\Http\Controllers\FormController::class, 'get_form'])
        ->name('get_form')->middleware('role:manager');
    Route::post('update_form', [App\Http\Controllers\FormController::class, 'update_form'])
        ->name('update_form')->middleware('role:manager');


    #--------------------Manager Accounts --------------- Manage Attendance Guard --------------------#
    Route::get('manager/manage/attendance/guard', [App\Http\Controllers\Manager\AttendanceController::class, 'index'])
        ->name('manage_attendance')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::get('manager/attendance/guard/{id}/{hash}', [App\Http\Controllers\Manager\AttendanceController::class, 'view_attendance'])
        ->name('view_attendance')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::get('manager/attendance/guard/time/{id}/{date}/{hash}', [App\Http\Controllers\Manager\AttendanceController::class, 'view_timing'])
        ->name('view_timing')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::get('manager/edit/attendance/guard/time/{id}/{hash}', [App\Http\Controllers\Manager\AttendanceController::class, 'edit_timing'])
        ->name('edit_timing')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::get('manager/create/attendance/guard/{id}', [App\Http\Controllers\Manager\AttendanceController::class, 'attendance'])
        ->name('attendance')->where('any', '[\/\w\.-]*')->middleware('role:manager');
    Route::post('manager/save/attendance/guard', [App\Http\Controllers\Manager\AttendanceController::class, 'save_guard_attendance'])
        ->name('save_guard_attendance')->middleware('role:manager');
    Route::post('manager/edit/attendance/guard', [App\Http\Controllers\Manager\AttendanceController::class, 'edit_guard_attendance'])
        ->name('edit_guard_attendance')->middleware('role:manager');




});