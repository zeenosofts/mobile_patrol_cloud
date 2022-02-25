<?php

namespace App\Http\Traits;

use App\Models\Attendance;
use App\Models\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AttendanceTrait{

    use PhpFunctionsTrait,CompanySettingTrait;
    public function create_guard_attendance($guard_id,$client_id,$schedule_id,$admin_id,$time_in,$time_out,$date,$timezone){
        $attendance=new Attendance();
        $attendance->guard_id=$guard_id;
        $attendance->client_id=$client_id;
        $attendance->schedule_id=$schedule_id;
        $attendance->admin_id=$admin_id;
        $attendance->time_in=$this->convertHtmlDateTimeToDbFormat($time_in,$timezone);
        $attendance->time_out=$this->convertHtmlDateTimeToDbFormat($time_out,$timezone);
        $attendance->date=$this->convertDateToDbFormat($date);
        $attendance->save();
        return back();
    }
    public function update_guard_attendance($id,$client_id, $time_in, $time_out, $date, $timezone){

        Attendance::where('id',$id)->update([
            "client_id"=>$client_id,
            "time_in"=>$this->convertHtmlDateTimeToDbFormat($time_in,$timezone),
            "time_out"=>$this->convertHtmlDateTimeToDbFormat($time_out,$timezone),
            "date"=>$this->convertDateToDbFormat($date),
        ]);
        return back();
    }
    public function calculateTimeAttendance($user_id,$date){
        $attendance=Attendance::select('*', DB::raw("SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(time_out,time_in) )) ) as 'total'"))->where('guard_id',$user_id)->where('date',$date)->where('status',1)->first();
        return $attendance->total;
    }

    public function showGuardAttendance($user_id,$from,$to){
        $attendance = Attendance::whereHas('user', function ($query) use ($user_id) {
            $query->where('status', 1)->where('id', $user_id);
        })->with(array('user'))->whereBetween('date', [$from, $to])->paginate(5);
        return $attendance;
    }
    public function showAllGuardAttendance(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $guards = Attendance::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->whereHas('user',function ($query) {
            $query->where('status',1);
        })->with(array('admin','user'))->paginate(15);
        dd($guards);


            Attendance::whereHas('guard', function ($query) {
        })->with(array('guard'))->paginate(5);
        return $attendance;
    }


    // Function for the Api
    public function check_time_out($user_id,$date){
        $attendance = Attendance::where('user_id',$user_id)->whereDate('date',$date)->where('time_out','')->get();
        if (count($attendance) > 0){
            return true;
        }else{
            return false;
        }

    }

}
