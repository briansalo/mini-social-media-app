<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Post;
use App\Models\Friendship;
use App\Models\User;
use App\Models\Activity;
use Carbon\Carbon;
class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']); //only auth user user can access this controller
    }

    public function Profile(){

         $allpost = Post::all();

      //this array contains post that current user has been tagged      
         $tag_post=[];
            foreach($allpost as $data){
               $tagger= [];
               $post= [];  
                   foreach($data->users as $tag){
                    $post = $data->id;            
                    $tagger[] = $tag->id;
                    }//for each
                //check if the current user is in the tagged
                if(in_array(auth::id(),$tagger)){
                        $tag_post[] = $post;
                   }//endif
             }//foreach

          $data['profile_post']= Post::where('user_id', auth::id())
          ->orWhereIn('id',$tag_post)
          ->orderBy('updated_at', 'DESC')
          ->get();

          //get the date when it posted
            $profile_date=[];
            foreach($data['profile_post'] as $row){
                $profile_date[]=carbon::create($row->updated_at)->diffForHumans();
            }
            
        return view('backend.profile.profile', $data)->with('profile_date', $profile_date);
    }

    public function ProfileUpdate(Request $request){

        $id = Auth::user()->id;

        $update = User::find($id);
        $update->name = $request->name;

        if($request->file('cover_photo')){  // if there's an image
            $file= $request->file('cover_photo'); // store the image in the variable
            @unlink(public_path('upload/cover_photo/'.$update->cover_photo)); //to delete the previous image
            $filename = date('YmdHi').$file->getClientOriginalName(); // make own name of the images
            $file->move(public_path('upload/cover'),$filename); //location of the storage
            $update->cover_photo = $filename;
        }

        if($request->file('profile')){  // if there's an image
            $file= $request->file('profile'); // store the image in the variable
            @unlink(public_path('upload/profile/'.$update->profile_photo)); //to delete the previous image
            $filename = date('YmdHi').$file->getClientOriginalName(); // make own name of the images
            $file->move(public_path('upload/profile'),$filename); //location of the storage
            $update->profile_photo = $filename;
        }
        $update->save();

        $notification = array(
            'message' => "Profile Update Successfully",
            'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
        );
        return redirect()->route('profile')->with($notification);
    }



    public function StalkProfile($id){

           $data['stalk_profile'] = User::find($id);

           $friend = Friendship::where('first_user_id', $id)->where('status', 'confirmed')->pluck('second_user_id')->toArray();
           $friend1 = Friendship::where('second_user_id', $id)->where('status', 'confirmed')->pluck('first_user_id')->toArray();

            //get all friends of stalked user
           $data['get_all_friends'] = User::whereIn('id', $friend)->orWhereIn('id', $friend1)->get();

           //check if the current user is friend of the stalk user then get all the public post and only friends post of the stalked user
           if(in_array(auth::id(), $friend) or in_array(auth::id(), $friend1)){
                $privacy_id = ['1','2'];
           }else{
                $privacy_id = ['1'];
           }

          $data['profile_post']= Post::where('user_id', $id)
          ->WhereIn('privacy_id',$privacy_id)
          ->orderBy('updated_at', 'DESC')
          ->get();

          //get the date when it posted
            $profile_date=[];
            foreach($data['profile_post'] as $row){
                $profile_date[]=carbon::create($row->updated_at)->diffForHumans();
            }
            

            //-----insert activity----//
            $activity = new Activity;
            $activity->auth_id = Auth::id();
            $activity->user_id = $id;
            $activity->activity_status = '11'; //stalk a profile
            $activity->save();

         return view('backend.profile.stalk_profile', $data)->with('profile_date', $profile_date);
    }


}
