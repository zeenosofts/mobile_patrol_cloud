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

    public function getLocalTimeInAttribute(){
        return $this->convertWithRespectToTimeZone($this->time_in);
    }
    public function getLocalTimeOutAttribute(){
        return $this->convertWithRespectToTimeZone($this->time_out);
    }
    public function getLocalTimeAttribute(){
        return $this->calculateTimeAttendance($this->guard_id,$this->date);
    }
    public function getLocalDateAttribute(){
        return $this->convertDateToHtmlFormat($this->date);
    }
}
