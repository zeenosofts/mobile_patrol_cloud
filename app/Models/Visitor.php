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

    public $appends = ['local_time'];

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
        return $this->convertDateTimeToDbFormat($this->convertWithRespectToTimeZone($this->created_at, $this->admin_id));
    }
}
