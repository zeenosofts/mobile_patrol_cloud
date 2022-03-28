<?php

namespace App\Models;

use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\ScheduleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    use HasFactory, AttendanceTrait, ScheduleTrait;

    public $appends = ['local_time','local_time_out'];

    public function visitor_report_images(){
        return $this->hasMany(VisitorImages::class);
    }

    public function guards(){
        return $this->belongsTo(Guard::class,'guard_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function getLocalTimeAttribute(){
        if($this->time_in != null) {
            return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone($this->time_in, $this->admin_id));
        }else{
            return null;
        }
    }
    public function getLocalTimeOutAttribute(){
        if($this->time_out != null) {
            return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone($this->time_out, $this->admin_id));
        }else{
            return null;
        }
    }
}
