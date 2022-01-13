<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ScheduleTrait;
use App\Models\Attendance;
use App\Models\Client;
use App\Models\Guard;
use App\Models\Schedule;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class AttendanceController extends Controller
{
    //
    use  ResponseTrait, PhpFunctionsTrait,CompanySettingTrait;

    public function index(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $guards = Guard::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->with(array('admin','user'))->paginate(5);
        return view('manager.guard.attendance.manage',compact('guards'))->with('title','Manage Attendance');
    }
    public function view_attendance(Request $request){
        $guard_id=$request->id;
        $attendance=Attendance::where('guard_id',$guard_id)->paginate(5);
        return view('manager.guard.attendance.attendance',['attendance'=>$attendance,'guard_id'=>$guard_id])->with('title','Guard Attendance');
    }
    public function view_timing(Request $request){
        $guard_id=$request->id;
        $attendance=Attendance::where('guard_id',$guard_id)->where('date',$request->date)->paginate(5);
        return view('manager.guard.attendance.timing',['attendance'=>$attendance,'guard_id'=>$guard_id])->with('title','Guard Attendance');
    }

    public function attendance(Request $request){
        $guard_id=$request->id;
        return view('manager.guard.attendance.create',['guard_id'=>$guard_id])->with('title','Create Attendance');
    }


    public function edit_timing(Request $request){
        $attendance=Attendance::where('id',$request->id)->first();
        return view('manager.guard.attendance.edit',['attendance'=>$attendance])->with('title','fsdfsd Attendance');
    }

    public function save_guard_attendance(Request $request){
        $attendance=new Attendance();
        $attendance->guard_id=$request->id;
        $attendance->time_in=$this->convertHtmlDateTimeToDbFormat($request->time_in,$request->timezone);
        $attendance->time_out=$this->convertHtmlDateTimeToDbFormat($request->time_out,$request->timezone);
        $attendance->date=$request->date;
        $attendance->save();
        return back();
    }
}
