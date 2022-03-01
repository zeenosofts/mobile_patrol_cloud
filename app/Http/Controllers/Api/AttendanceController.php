<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\AttendanceTrait;

use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use AttendanceTrait,ResponseTrait,AccountsTrait;

    public function save_guard_attendance(Request $request){
        try{
            $attendance=$this->check_time_out($request->schedule_id);
            if (count($attendance) > 0){
                $attendance_id=$this->get_attendance_id($request->schedule_id);
                $this->edit_guard_attendance_api($attendance_id);
                return $this->returnApiResponse(201, 'success', array('response' => 'Guard Time Out Successfully'));
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

    public function get_guard_attendance(Request $request){
        try{
            $date = Carbon::parse($request->date1)->toDateString();
            $guard=$this->get_guard_table_row($request->user()->id);
            $attendance=$this->guard_attendance($guard->id,$date);
            //return $this->returnApiResponse(200, 'success', array('attendance' => $guard));
            return $this->returnApiResponse(200, 'success', array('attendance' => $attendance));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }
}
