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
        $this->create_guard_attendance($request->guard_id,$request->client_id,$request->schedule_id,$request->admin_id,$request->time_in,$request->time_out,$request->date,$request->timezone);
        return $this->returnApiResponse(200, 'success', array('response' => 'Guard Attendance create Successfully'));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }
    public function check_guard_time_out(Request $request){
        try{
            $check_time_out=$this->check_time_out($request->user()->id,$request->date);
            return $this->returnApiResponse(200, 'success', array('check_time_out' => $check_time_out));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }
}
