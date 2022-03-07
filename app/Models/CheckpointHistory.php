<?php

namespace App\Models;

use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ScheduleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckpointHistory extends Model
{
    use HasFactory, PhpFunctionsTrait, ScheduleTrait;

    public $appends = ['local_time'];

    public function guards(){
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function schedules(){
        return $this->belongsTo(Schedule::class);
    }

    public function checkpoint(){
        return $this->belongsTo(Checkpoint::class);
    }

    public function getLocalTimeAttribute(){
        if($this->created_at != null) {
            return $this->convertDateTimeToReadableDayTimeFormat($this->convertWithRespectToTimeZone($this->created_at, $this->admin_id));
        }else{
            return NULL;
        }
    }
}
