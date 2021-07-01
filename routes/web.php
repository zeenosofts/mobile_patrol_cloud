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
    Route::post('save_guard', [App\Http\Controllers\Manager\GuardController::class, 'save_guard'])
        ->name('save_guard')->middleware('role:manager');
    Route::get('manager/manage/guard', [App\Http\Controllers\Manager\GuardController::class, 'manage_guard'])
        ->name('manage_guard')->middleware('role:manager'); //
    Route::get('manager/edit/guard/{guard_id}/{hash}', [App\Http\Controllers\Manager\GuardController::class, 'edit_guard'])
        ->name('edit_guard')->middleware('role:manager');
    Route::post('update_guard', [App\Http\Controllers\Manager\GuardController::class, 'update_guard'])
        ->name('update_guard')->middleware('role:manager');//
    Route::post('change_status', [App\Http\Controllers\Manager\GuardController::class, 'change_status'])
        ->name('change_status')->middleware('role:manager');
});
