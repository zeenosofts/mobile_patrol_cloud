<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Attendance;
use App\Models\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    //
    use  ResponseTrait, PhpFunctionsTrait, CompanySettingTrait, AttendanceTrait;

    public function index()
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $guards = Guard::whereHas('admin', function ($query) use ($admin_id) {
            $query->where('admin_id', $admin_id);
        })->with(array('admin', 'user'))->paginate(5);
        return view('manager.guard.attendance.manage', compact('guards'))->with('title', 'Manage Attendance');
    }

    public function view_attendance(Request $request)
    {
        $guard_id = $request->id;
        $attendance = Attendance::where('guard_id', $guard_id)->groupBy('date')->paginate(5);
        return view('manager.guard.attendance.attendance', ['attendance' => $attendance, 'guard_id' => $guard_id])->with('title', 'Guard Attendance');
    }

    public function view_timing(Request $request)
    {
        $guard_id = $request->id;
        $attendance = Attendance::where('guard_id', $guard_id)->where('date', $request->date)->paginate(5);
        return view('manager.guard.attendance.timing', ['attendance' => $attendance, 'guard_id' => $guard_id])->with('title', 'Guard Attendance');
    }

    public function attendance(Request $request)
    {
        $guard_id = $request->id;
        $time_zone = Session::get('timezone');
        return view('manager.guard.attendance.create', ['guard_id' => $guard_id, 'timezone' => $time_zone])->with('title', 'Create Attendance');
    }


    public function edit_timing(Request $request)
    {
        $attendance = Attendance::where('id', $request->id)->get();
        $time_zone = Session::get('timezone');
        return view('manager.guard.attendance.edit', ['attendance' => $attendance, 'timezone' => $time_zone])->with('title', 'Edit Attendance');
    }

    public function save_guard_attendance(Request $request)
    {
        try {
            $this->create_guard_attendance($request->id, $request->time_in, $request->time_out, $request->date, $request->timezone);
            return $this->returnWebResponse('Guard Attendance created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }

    } public function edit_guard_attendance(Request $request)
    {
        try {
            $this->update_guard_attendance($request->id, $request->time_in, $request->time_out, $request->date, $request->timezone);
            return $this->returnWebResponse('Guard Attendance edit successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }

    }
}
