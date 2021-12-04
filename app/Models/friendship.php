<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friendship extends Model
{

    public function user_info(){
        return $this->belongsTo(User::class,'first_user_id','id');
    }

    public function second_user_info(){
        return $this->belongsTo(User::class,'second_user_id','id');
    }

}
