<?php

namespace App\Http\Traits;

use App\Models\MobilePatrol;
use App\Models\Notification;
use App\Models\Visitor;
use App\Models\VisitorImages;

trait MobilePatrolTrait {

    public function get_all_mobile_patrols_trait($guard_id,$admin_id){
        $mobile_patrols = MobilePatrol::where('admin_id',$admin_id)->whereIn('guard_id',[0,$guard_id])->with(array('client'))->get();
        return $mobile_patrols;
    }

    public function get_all_mobile_patrols_reports_by_id_trait($admin_id,$id){
        $mobile_patrols = MobilePatrol::where('admin_id',$admin_id)->where('id',$id)->with(array('mobile_patrol_reports' => function ($query){
            $query->with('mobile_patrol_report_images');
        }))->first();
        return $mobile_patrols;
    }

}
