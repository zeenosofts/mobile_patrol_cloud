<?php

namespace App\Http\Traits;

use App\Models\Schedule;

trait ScheduleTrait {

    public function create_schedule($admin_id,$client_id,$guard_id,$from_date_time,$to_date_time,$instructions){
        $save = new Schedule();
        $save->admin_id = $admin_id;
        $save->client_id = $client_id;
        $save->guard_id = $guard_id;
        $save->from_date_time = $from_date_time;
        $save->to_date_time = $to_date_time;
        $save->instructions = $instructions;
        $save->save();
        return $save;
    }

    public function checkIfDateAndTimeAlreadyExists($guard_id,$from_date_time,$to_date_time){
        $check = Schedule::where('guard_id',$guard_id)
            ->orWhere(function ($query) use ($from_date_time){
                $query->where('from_date_time','<=',$from_date_time);
                $query->orWhere('to_date_time','>=',$from_date_time);
            })->orWhere(function ($query) use ($to_date_time){
                $query->where('from_date_time','<=',$to_date_time);
                $query->orWhere('to_date_time','>=',$to_date_time);
            })->get();
        if(count($check) > 0){
            return false;
        }else{
            return true;
        }
    }
}
