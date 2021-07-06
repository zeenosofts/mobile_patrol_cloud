<?php

namespace App\Http\Traits;

use App\Models\Client;

trait ClientTrait {

    public function save_as_client($admin_id,$user_id,$client_name,$client_email,$client_address,$client_phone){
        $save = new Client();
        $save->admin_id = $admin_id;
        $save->user_id = $user_id;
        $save->client_name = $client_name;
        $save->client_email = $client_email;
        $save->client_address = $client_address;
        $save->client_phone = $client_phone;
        $save->save();
        return $save;
    }

    public function update_as_client($client_id,$client_name,$client_email,$client_address,$client_phone){
        $update = Client::where('id',$client_id)->update([
         'client_name' => $client_name,
        'client_email' => $client_email,
        'client_address'=> $client_address,
        'client_phone' => $client_phone,
        ]);
    }
}
