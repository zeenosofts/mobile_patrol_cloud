<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ScheduleTrait;
use App\Models\Client;
use App\Models\Guard;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    //
    use CompanySettingTrait, ScheduleTrait, ResponseTrait, PhpFunctionsTrait;

    public function index(){
        $admin_id = $this->getAdminID(Auth::user()->id);

        $clients = Client::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->whereHas('user',function ($query){
            $query->where('status',1);
        })->with(array('admin','user'))->get();

        $guards = Guard::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->whereHas('user',function ($query){
            $query->where('status',1);
        })->with(array('admin','user'))->get();

        $schedule = Schedule::first();
        return view('manager.schedule.index',compact('clients','guards','schedule'))->with('title','Create Schedule');
    }

    public function save_schedule(Request $request){

        $admin_id = $this->getAdminID(Auth::user()->id);
        if($request->repeat == 'false'){
            //Check 1 Same Date
            $from_date_time = '2021-07-05 23:43:00';
            $to_date_time = '2021-07-06 01:42:00';
            $checkDuplication = $this->checkIfDateAndTimeAlreadyExists($request->guard_id,$from_date_time,$to_date_time);
            return response($checkDuplication == false ? 'no' : 'free');
            $from_date_time = $this->convertDateTimeToDbFormat($request->from_date_time);
            $to_date_time = $this->convertDateTimeToDbFormat($request->to_date_time);

            $this->create_schedule($admin_id,$request->client_id,$request->guard_id,$from_date_time,$to_date_time,$request->instructions);
            return $this->returnApiResponse(200,'success',array());
        }
    }
}
