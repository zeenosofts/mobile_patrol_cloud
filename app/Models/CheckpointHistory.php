<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckpointHistory extends Model
{
    use HasFactory;
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
}
