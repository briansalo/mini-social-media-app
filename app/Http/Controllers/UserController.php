<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function log_out(){
        if(auth::check()){
            User::where('id', Auth::user()->id)->update(['last_activity'=> Carbon::now()->subMinutes(2)]);
        }
        Auth::logout();
        return redirect('/login');
    }

 
    public function MonitorUserScroll(){

        $now = Carbon::now();
        User::where('id', auth::user()->id)->update(['last_activity'=> $now]);
        
    }

}
