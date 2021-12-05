<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\models\Post;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class Post extends Model
{

    public function user_info(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function feeling_info(){
        return $this->belongsTo(Feeling::class,'feeling_id','id');
    }

    public function tag_friend_info(){
        return $this->belongsTo(User::class,'tag_friend_id','id');
    }

    public function privacy_info(){
        return $this->belongsTo(PostStatus::class,'privacy_id','id');
    }

    //for tagged post
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }


}
