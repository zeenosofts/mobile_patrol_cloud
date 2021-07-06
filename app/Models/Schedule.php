<?php

namespace App\Models;

use App\Http\Traits\CompanySettingTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Schedule extends Model
{
    use HasFactory, CompanySettingTrait;

    protected $casts = [
        'from_date_time' => 'datetime:Y-m-d H:i',
        'to_date_time' => 'datetime:Y-m-d H:i',
    ];

    public $appends = ['local_from_date_time','local_to_date_time'];

    public function guards(){
        return $this->belongsTo(Guard::class);
    }

    public function clients(){
        return $this->belongsTo(Guard::class);
    }

    public function admin(){
        return $this->belongsTo(Guard::class);
    }
    //Carbon::parse($request->ShootDateTime)->timezone('America/Los_Angeles');

    public function getLocalFromDateTimeAttribute(){
        $company_details = $this->getCompanyDetails(Auth::user()->id);
        return Carbon::parse($this->from_date_time)->timezone($company_details->company_time_zone);
    }

    public function getLocalToDateTimeAttribute(){
        $company_details = $this->getCompanyDetails(Auth::user()->id);
        return Carbon::parse($this->to_date_time)->timezone($company_details->company_time_zone);
    }
}
