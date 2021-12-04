<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Activity;
use App\Models\Post;

class LikeController extends Controller
{
    public function Like(Request $request){
        
        $create = new Like;
        $create->post_id = $request->post_id;
        $create->user_id = Auth::id();
        $create->save();

            //-----insert activity----//
        $post = Post::find($request->post_id);
        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->user_id = $post->user_id;
        $activity->activity_status = '9'; //like a post
        $activity->save();

    }

    public function Unlike(Request $request){

        Like::where('post_id', $request->post_id)->where('user_id', Auth::id())->delete();

            //-----insert activity----//
        $post = Post::find($request->post_id);
        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->user_id = $post->user_id;
        $activity->activity_status = '10'; //Unlike a post
        $activity->save();

    }
}
