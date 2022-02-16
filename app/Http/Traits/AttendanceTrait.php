<?php

namespace App\Http\Traits;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

trait AttendanceTrait{

    use PhpFunctionsTrait;
    public function create_guard_attendance($user_id,$time_in,$time_out,$date,$timezone){
        $attendance=new Attendance();
        $attendance->user_id=$user_id;
        $attendance->time_in=$this->convertHtmlDateTimeToDbFormat($time_in,$timezone);
        $attendance->time_out=$this->convertHtmlDateTimeToDbFormat($time_out,$timezone);
        $attendance->date=$this->convertDateToDbFormat($date);
        $attendance->save();
        return back();
    }
    public function update_guard_attendance($id, $time_in, $time_out, $date, $timezone){

        Attendance::where('id',$id)->update([
            "time_in"=>$this->convertHtmlDateTimeToDbFormat($time_in,$timezone),
            "time_out"=>$this->convertHtmlDateTimeToDbFormat($time_out,$timezone),
            "date"=>$this->convertDateToDbFormat($date),
        ]);
        return back();
    }
    public function calculateTimeAttendance($user_id,$date){
        $attendance=Attendance::select('*', DB::raw("SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(time_out,time_in) )) ) as 'total'"))->where('user_id',$user_id)->where('date',$date)->where('status',1)->first();
        return $attendance->total;
    }

    public function showGuardAttendance($user_id,$from,$to){
        $attendance = Attendance::whereHas('user', function ($query) use ($user_id) {
            $query->where('status', 1)->where('id', $user_id);
        })->with(array('user'))->whereBetween('date', [$from, $to])->paginate(5);
        return $attendance;
    }
    public function showAllGuardAttendance($user_id){
        $attendance= Attendance::whereHas('user', function ($query) use ($user_id) {
            $query->where('status', 1);
        })->with(array('user'))->paginate(5);
        return $attendance;
    }

}
