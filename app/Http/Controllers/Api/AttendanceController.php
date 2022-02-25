<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AttendanceTrait;

use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use AttendanceTrait,ResponseTrait;

    public function save_guard_attendance(Request $request){
        try{
        $this->create_guard_attendance_api($request->schedule_id);
        return $this->returnApiResponse(200, 'success', array('response' => 'Guard Attendance create Successfully'));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }

    public function update_guard_attendance(Request $request){
        try{
            $this->edit_guard_attendance_api($request->attendance_id);
            return $this->returnApiResponse(200, 'success', array('response' => 'Guard Attendance Time Out Successfully'));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }


    public function check_guard_time_out(Request $request){
        try{
            $attendance=$this->check_time_out($request->user()->id,$request->date);
            if (count($attendance) > 0){
                return $this->returnApiResponse(200, 'success', array('check_time_out' => true,'attendance'=>$attendance));
            }else{
                return $this->returnApiResponse(200, 'success', array('check_time_out' => false));
            }
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }
}
