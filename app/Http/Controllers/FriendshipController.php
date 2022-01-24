<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Friendship;
use App\Models\Post;
use App\Models\Activity;

use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']); //only auth user user can access this controller
    }

    public function ListOfUser(){

        //get all the user who received friend request from this current(auth) user
        $pending_user =Friendship::where('second_user_id', Auth::id())->where('status','pending')->pluck('first_user_id')->toArray();

        // get all the user who are friends for this current(auth) user
        $friend_1 =Friendship::where('second_user_id', Auth::id())->where('status','confirmed')->pluck('first_user_id')->toArray();
        $friend_2 =Friendship::where('first_user_id', Auth::id())->where('status','confirmed')->pluck('second_user_id')->toArray();

        $data['alldata'] = User::where('id', '!=', Auth::id())
        ->whereNotIn('id', $pending_user)
        ->whereNotIn('id', $friend_1)
        ->whereNotIn('id', $friend_2)
        ->orderBy('name', 'ASC')
        ->get();

        // if the current user click add friend button. it will change to cancel friend request button
        $friendship=[];
             foreach($data['alldata'] as $row){
                $friendship[] = Friendship::where('first_user_id', Auth::id())
                ->where('second_user_id', $row->id)
                ->where('status', 'pending')
                ->get();
               
             }

           //get all friends of each  user
           $friends_of_each_user=[];
             foreach($data['alldata'] as $row){
            
               $friend = Friendship::where('first_user_id', $row->id)
               ->where('status', 'confirmed')->pluck('second_user_id')->toArray();

               $friend1 = Friendship::where('second_user_id', $row->id)
               ->where('status', 'confirmed')->pluck('first_user_id')->toArray();

              $friends_of_each_user[] = User::whereIn('id', $friend)->orWhereIn('id', $friend1)->get();
           }


        return view('backend.friendship.list-of-user',$data)->with(compact('friendship','friends_of_each_user'));

    }


    public function AddFriend($id){

        $data = new Friendship();
        $data->first_user_id = Auth::id();
        $data->second_user_id = $id;
        $data->status = 'pending';
        $data->save();

        //-----insert activity----//
        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->user_id = $id;
        $activity->activity_status = '4'; //add friend
        $activity->save();

        $user = User::find($id);
        $notification = array(
            'message' => "Sending Friend Request to $user->name ",
            'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
        );
        return redirect()->route('list_of_user')->with($notification);

    }

    public function CancelFriendRequest($id){

        Friendship::where('first_user_id', Auth::id())
        ->where('second_user_id', $id)
        ->where('status', 'pending')
        ->delete();

        //-----insert activity----//
        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->user_id = $id;
        $activity->activity_status = '5'; //cancel add friend
        $activity->save();

        $user = User::find($id);
        $notification = array(
            'message' => "Cancel Friend Request to $user->name ",
            'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
        );
        return redirect()->route('list_of_user')->with($notification);

    }


    public function FriendRequest(){
        

        $friend =Friendship::where('second_user_id', Auth::id())->where('status','pending')->pluck('first_user_id')->toArray();

        $data['alldata'] = User::whereIn('id',$friend)->get();

           //get all friends of each  user
        $friends_of_each_user=[];
         foreach($data['alldata'] as $row){
     
               $friend = Friendship::where('first_user_id', $row->id)
               ->where('status', 'confirmed')->pluck('second_user_id')->toArray();

               $friend1 = Friendship::where('second_user_id', $row->id)
               ->where('status', 'confirmed')->pluck('first_user_id')->toArray();

              $friends_of_each_user[] = User::whereIn('id', $friend)->orWhereIn('id', $friend1)->get();
           }

        return view('backend.friendship.friend_request',$data)->with(compact('friends_of_each_user'));
    }


    public function AcceptFriendRequest($id){

            Friendship::where('first_user_id', $id)
            ->where('second_user_id', Auth::id())
            ->where('status', 'pending')
            ->update(['status'=> 'confirmed']);

            //-----insert activity----//
            $activity = new Activity;
            $activity->auth_id = Auth::id();
            $activity->user_id = $id;
            $activity->activity_status = '6'; //accept request
            $activity->save();


            $user = User::find($id);
            $notification = array(
                'message' => "You and $user->name are now friends ",
                'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
            );
            return redirect()->route('friend_request')->with($notification);
    }

    public function DontAcceptFriendRequest($id){

            Friendship::where('first_user_id', $id)
            ->where('second_user_id', Auth::id())
            ->where('status', 'pending')
            ->delete();

            //-----insert activity----//
            $activity = new Activity;
            $activity->auth_id = Auth::id();
            $activity->user_id = $id;
            $activity->activity_status = '7'; //dont accept request
            $activity->save();

            $user = User::find($id);
            $notification = array(
                'message' => "You did not accept $user->name ",
                'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
            );
            return redirect()->route('friend_request')->with($notification);
    }

    public function ListOfFriend(){

        $list = Friendship::where('first_user_id', Auth::id())->where('status', 'confirmed')->pluck('second_user_id')->toArray();
        $list1 = Friendship::where('second_user_id', Auth::id())->where('status', 'confirmed')->pluck('first_user_id')->toArray();

        $data['alldata'] = User::whereIn('id', $list)->orWhereIn('id', $list1)->orderBy('name', 'ASC')->get();

         //get all friends of each  user
        $friends_of_each_user=[];
         foreach($data['alldata'] as $row){
     
               $friend = Friendship::where('first_user_id', $row->id)
               ->where('status', 'confirmed')->pluck('second_user_id')->toArray();

               $friend1 = Friendship::where('second_user_id', $row->id)
               ->where('status', 'confirmed')->pluck('first_user_id')->toArray();

              $friends_of_each_user[] = User::whereIn('id', $friend)->orWhereIn('id', $friend1)->get();
           }

        return view('backend.friendship.list_of_friend',$data)->with(compact('friends_of_each_user'));

    }


    public function UnfriendUser($id){

        Friendship::where('first_user_id', $id)
        ->where('second_user_id', Auth::id())
        ->where('status', 'confirmed')
        ->delete();

        Friendship::where('first_user_id', Auth::id())
        ->where('second_user_id', $id)
        ->where('status', 'confirmed')
        ->delete();

        //-------------removing all the tag of current user and unfriend user-------------//
        $post = Post::where('user_id', Auth::id())->orwhere('user_id', $id)->get();

          //get all the post of current user and the unfriend user that been tagging each other
         $tag_post=[];
            foreach($post as $row){
                 $check_tag=[];          
                foreach($row->users as $tag){
                    $post = $row->id; 
                    $check_tag[] = $tag->id;
                }
                    if(in_array($id,$check_tag) or in_array(auth::id(),$check_tag)){
                       $tag_post[] = $post;
                      }
            } 

  //to avoid error we need to detach one by one this, that's why i use for loop instead of Post::whereIN('id', $tag_post)->get()
        //detach current user and unfriend user to the post that been tagging each other
        for($x=0; $x<count($tag_post); $x++){
            $test = Post::where('id', $tag_post[$x])->first();
            $test->users()->detach($id);
            $test->users()->detach(auth::id());
        }


            //-----insert activity----//
        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->user_id = $id;
        $activity->activity_status = '8'; //remove tag
        $activity->save();

        $user = User::find($id);
        $notification = array(
            'message' => "You and $user->name are no longer friends ",
            'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
        );

        return redirect()->route('list_of_friend')->with($notification);

    }

}
