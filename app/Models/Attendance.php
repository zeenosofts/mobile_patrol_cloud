<?php

namespace App\Models;

use App\Http\Traits\ScheduleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory,ScheduleTrait;

    public $appends = ['local_time_in', 'local_time_out'];

    public function getLocalTimeInAttribute(){
        return $this->convertWithRespectToTimeZone($this->time_in);
    }
    public function getLocalTimeOutAttribute(){
        return $this->convertWithRespectToTimeZone($this->time_out);
    }
}
