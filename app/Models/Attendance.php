<?php

namespace App\Models;

use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\ScheduleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory,ScheduleTrait,AttendanceTrait;

    public $appends = ['local_time_in', 'local_time_out','local_time','local_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function getLocalTimeInAttribute(){
        return $this->convertWithRespectToTimeZone($this->time_in,$this->admin_id);
    }
    public function getLocalTimeOutAttribute(){
        return $this->convertWithRespectToTimeZone($this->time_out,$this->admin_id);
    }
    public function getLocalTimeAttribute(){
        return $this->calculateTimeAttendance($this->guard_id,$this->date);
    }
    public function getLocalDateAttribute(){
        return $this->convertDateToHtmlFormat($this->date);
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
}
