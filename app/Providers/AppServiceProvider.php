<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use Illuminate\Support\Facades\View;
use App\models\Friendship;
use App\models\User;
use App\models\Post;
use App\models\Like;
use App\models\Feeling;
use App\models\Postprivacy;
use App\models\AssignPost;
use App\models\Activity;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

if($this->app->environment('production')) {
    \URL::forceScheme('https');
}

    //compose all the views....
    view()->composer('*', function ($view) 
    {
  
       if(Auth::check()){
           $id = auth::id();

        //......--------------get all the latest user---------------------//
           $latest_user = User::orderBy('id','desc')->take(2)->get();
            $view->with('latest_user', $latest_user); 


        //......--------------get all user---------------------//
           $all_user = User::where('id', '!=', $id)->orderBy('name','asc')->get();
            $view->with('all_user', $all_user); 

            
        //.......................for Write Post..............................//  
           //get all feeling
           $view->with('feeling', Feeling::all()); 

           // get all post_status
           $view->with('post_status', PostPrivacy::all());

           //get all friends of current user
           $friend = Friendship::where('first_user_id', $id)->where('status', 'confirmed')->pluck('second_user_id')->toArray();
           $friend1 = Friendship::where('second_user_id', $id)->where('status', 'confirmed')->pluck('first_user_id')->toArray();

           $value = User::whereIn('id', $friend)->orWhereIn('id', $friend1)->get();
           $view->with('all_friends_of_current_user', $value); 


        //.......................for News Feed..............................//  

            //retrieve all the post of the current user, post of friends of the current user and post of a user that set to public
            $post= Post::where('user_id', $id)
            ->orwhere('privacy_id', '1')
            ->orwhereIn('user_id', $friend)
            ->orWhereIn('user_id',$friend1)
            ->orderBy('updated_at', 'DESC')
            ->get();

            //get the date when it posted
            $date=[];
            foreach($post as $row){
                $date[]=carbon::create($row->updated_at)->diffForHumans();
            }   
             $view->with('post', $post); 
             $view->with('date', $date); 

             //retrieve all the post that current user has like
             $like = Like::where('user_id', $id)->pluck('post_id')->toArray();
             $view->with('like', $like); 


              //----------count how many friend request(left-side)----------//
             $friend_request =Friendship::where('second_user_id', $id)->where('status','pending')->pluck('first_user_id')->toArray();
             $view->with('friend_request', $friend_request); 

            
            //------------------User activity---------------//

                $activities = Activity::where('auth_id', $id)->orderBy('id','DESC')->get();
                if(count($activities) > 30){
                    $try = Activity::where('auth_id', $id)->first()->delete();
                }
                $view->with('activities', $activities);

        }else{
                $view->with('all_friends_of_current_user', null);  
                $view->with('latest_user', null); 
                $view->with('all_user', null); 
        }
    });// view composer 


    }// public function boot
}
