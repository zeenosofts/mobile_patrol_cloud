<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorImages extends Model
{
    use HasFactory;
    public function getImageUrlAttribute(){
        if($this->images == null){
            return "";
        }
        return "https://square.cybermeteors.com/root/".$this->images;
    }
}
