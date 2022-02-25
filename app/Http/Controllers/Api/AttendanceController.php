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
            $attendance=$this->check_time_out($request->schedule_id);
            if (count($attendance) > 0){
                $this->edit_guard_attendance_api($request->attendance_id);
                return $this->returnApiResponse(200, 'success', array('response' => 'Guard Time Out Successfully'));
            }else{
                $this->create_guard_attendance_api($request->schedule_id);
                return $this->returnApiResponse(200, 'success', array('response' => 'Guard Time In Successfully'));

            }
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }

    public function check_guard_time_out(Request $request){
        try{
            $attendance=$this->check_time_out($request->schedule_id);
            if (count($attendance) > 0){
                return $this->returnApiResponse(200, 'success', array('check_time_out' => true));
            }else{
                return $this->returnApiResponse(200, 'success', array('check_time_out' => false));
            }
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }
}
