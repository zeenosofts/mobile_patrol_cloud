<?php

namespace App\Http\Traits;

trait FormTrait {

    use PhpFunctionsTrait;
    public function create_form(){
        $save = new Form();
        $save->admin_id = $admin_id;
        $save->client_id = $client_id;
        $save->guard_id = $guard_id;
        $save->from_date_time = $from_date_time;
        $save->to_date_time = $to_date_time;
        $save->instructions = $instructions;
        $save->save();
        return $save;
    }



}
