<?php

namespace App\Http\Traits;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

trait AttendanceTrait{

    use PhpFunctionsTrait;
    public function create_guard_attendance($guard_id,$time_in,$time_out,$date,$timezone){
        $attendance=new Attendance();
        $attendance->guard_id=$guard_id;
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
    public function calculateTimeAttendance($guard_id,$date){
        $attendance=Attendance::select('*', DB::raw("SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(time_out,time_in) )) ) as 'total'"))->where('guard_id',$guard_id)->where('date',$date)->first();
        return $attendance->total;
    }

}
