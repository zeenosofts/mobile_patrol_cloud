<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReportImages extends Model
{
    use HasFactory;

    public function getImagesAttribute($value){
        if($value == null){
            return "";
        }
         echo env("IMAGE_PATH").$value;
    }
}
