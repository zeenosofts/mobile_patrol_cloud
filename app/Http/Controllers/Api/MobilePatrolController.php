<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\MobilePatrolTrait;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;

class MobilePatrolController extends Controller
{
    //

    use  AccountsTrait, ImageUplaodTrait, ResponseTrait, MobilePatrolTrait;
    public function get_all_mobile_patrols(Request $request){
        try{
            $guard=$this->get_guard_table_row($request->user()->id);
            $mobile_patrols = $this->get_all_mobile_patrols_trait($guard->id,$guard->admin_id);
            return $this->returnApiResponse(200, 'success', array('response' => 'Mobile Patrols fetched Successfully','mobile_patrols' => $mobile_patrols));
        }catch(\Exception $e){
            return $this->returnApiResponse(401,'danger',array('error'=>$e->getMessage()));
        }
    }

    public function get_all_mobile_patrols_reports_by_id(Request $request){
        try{
            $guard=$this->get_guard_table_row($request->user()->id);
            $mobile_patrols = $this->get_all_mobile_patrols_reports_by_id_trait($guard->admin_id,$request->id);
            return $this->returnApiResponse(200, 'success', array('response' => 'Mobile Patrols Reports fetched Successfully','mobile_patrols' => $mobile_patrols));
        }catch(\Exception $e){
            return $this->returnApiResponse(401,'danger',array('error'=>$e->getMessage()));
        }
    }
}
