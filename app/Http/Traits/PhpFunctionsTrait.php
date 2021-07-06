<?php

namespace App\Http\Traits;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait PhpFunctionsTrait {

    public function removeSlashAndUpperCaseFirstLetter($variable){
        return ucfirst(str_replace('_',' ',$variable));
    }

    public function returnAuthUserAdminID($user_id){
        return User::findOrFail($user_id)->isAdmin->id;
    }

    public function checkHash($value,$hash){
        if(md5($value) == $hash){
            return true;
        }else{
            return false;
        }
    }

    public function convertDateTimeToDbFormat($datetime){
        return Carbon::parse($datetime)->format('Y-m-d H:i');
    }
}
