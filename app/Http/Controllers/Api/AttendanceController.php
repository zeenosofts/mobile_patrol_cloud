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
        $this->create_guard_attendance($request->user()->id,$request->time_in,$request->time_out,$request->date,$request->timezone);
        return $this->returnApiResponse(200, 'success', array('response' => 'Guard Attendance create Successfully'));
        }catch(\Exception $e){
            return $this->returnApiResponse('301','danger',array('error'=>$e->getMessage()));
        }

    }
}
