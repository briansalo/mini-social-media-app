<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Message;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $appends=['Isonline'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'last_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }  


    public function isonline(){
        $user = User::where('id', $this->id)->first();
        $now = Carbon::now();
        $last_activity= Carbon::create($user->last_activity);
        
         if($last_activity->addMinutes(1) >= $now){
                return true;
        }
        
        return false;
    }

    //FOR VUEJS
    public function getIsonlineAttribute(){

        $user = User::where('id', $this->id)->first();
        $now = Carbon::now();
        $last_activity= Carbon::create($user->last_activity);
        
         if($last_activity->addMinutes(1) >= $now){
                return true;
        }
        
        return false;
    }
}
