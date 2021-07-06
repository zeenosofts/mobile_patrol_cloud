<?php

namespace App\Http\Traits;

use App\Models\Checkpoint;

trait CheckpointTrait {

    public function save_qr_checkpoint($admin_id,$client_id,$qr_code){
        $save = new Checkpoint();
        $save->admin_id = $admin_id;
        $save->client_id = $client_id;
        $save->qr_code = $qr_code.md5($qr_code);
        $save->checkpoint_name = $qr_code;
        $save->save();
        return $save;
    }
}
