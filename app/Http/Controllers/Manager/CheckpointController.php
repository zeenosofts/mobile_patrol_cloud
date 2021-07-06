<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\CheckpointTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Checkpoint;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckpointController extends Controller
{
    //
    use CompanySettingTrait, ResponseTrait, CheckpointTrait;

    public function client_checkpoints(Request $request){
        $checkpoints = Checkpoint::with(array('client'))->where('client_id',$request->client_id)->paginate(15);
        return view('manager.client.checkpoint.index',compact('checkpoints'))->with('title','Manage Checkpoints');
    }

    public function create_qr_checkpoint(Request $request){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $this->validate($request, [
            'qr_code' => ['required', 'string', 'max:255'],
        ]);
        try{
            $save_checkpoint = $this->save_qr_checkpoint($admin_id,$request->client_id,$request->qr_code);
            return $this->returnWebResponse('Checkpoint QR created successfully', 'success');
        }catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }
}
