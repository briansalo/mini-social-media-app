<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Activity;
use App\Models\AssignPost;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']); //only auth user user can access this controller
    }

    public function PostStore(Request $request){

        $validatedData = $request->validate([
            'content' => 'required'
            
        ]);


            $create = new Post;
            $create->user_id = Auth::id();
            $create->content = $request->content;
            $create->feeling_id = $request->feeling;
              if($request->file('image')){  // if there's an image
                    $file= $request->file('image'); // store the image in the variable
                    $filename = date('YmdHi').$file->getClientOriginalName(); // make own name of the images
                    $file->move(public_path('upload/post'),$filename); //location of the storage
                    $create->image = $filename;
                }
            $create->privacy_id = $request->post_status;
            $create->save();
            $create->users()->attach($request->tagg_friend);

            //-------Insert Activity------//
            $activity = new Activity;
            $activity->auth_id = Auth::id();
            $activity->activity_status = '1'; //create post
            $activity->save();

            $notification = array(
                'message' => 'Post Created Successfully',
                'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
            );

            return redirect()->route('home')->with($notification);
    }


    public function EditPostModal(Request $request){
       
        $post = Post::where('id', $request->post_id)->first();
        $tagg_friend=[];

                foreach($post->users as $tag){
                    $tagg_friend[] = $tag->id;
                }
            
            $data = array('post_id' =>$post->id,
                            'content' => $post->content,
                            'feeling_id'=>$post->feeling_id,
                            'image'=>$post->image,
                            'privacy_id' =>$post->privacy_id,
                            'tagg_friend'=>$tagg_friend
                            
             );  
            echo json_encode($data);
    }


    public function PostUpdate(Request $request){

        $update = Post::where('id',$request->post_id)->first();

            if($request->content != null){
                $update->content = $request->content;
            }

            if(!empty($request->check_image)){
                  @unlink(public_path('upload/post/'.$update->image));
                  Post::where('id', $request->post_id)->update(['image'=> null]);
            }elseif($request->file('image')){  // if there's an image
                  $file= $request->file('image'); // store the image in the variable
                  @unlink(public_path('upload/post/'.$update->image)); //delete the previous image
                  $filename = date('YmdHi').$file->getClientOriginalName(); // make own name of the images
                  $file->move(public_path('upload/post'),$filename); //location of the storage
                  $update->image = $filename;                      
             }
        $update->user_id = Auth::id();   
        $update->feeling_id = $request->feeling;
        $update->privacy_id = $request->post_status;
        $update->save();
        $update->users()->sync($request->tagg_friend);


        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->activity_status = '2'; //update post
        $activity->save();

        $notification = array(
            'message' => 'Post Updated Successfully',
            'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
        );

        //check the previous url
        if(str_replace(url('/'), '', url()->previous())=="/profile"){
            return redirect()->route('profile')->with($notification);
        }else{
            return redirect()->route('home')->with($notification);
        }
    }


    public function DeletePostModal(Request $request){


       $delete = Post::where('id',$request->post_id_delete)->first();
       @unlink(public_path('upload/post/'.$delete->image)); //delete the previous image
       $delete->users()->detach();
       $delete->delete();

       //------Insert Activity------//
        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->activity_status = '3'; //delete post
        $activity->save();

        $notification = array(
            'message' => 'Post Deleted Successfully',
            'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
        );

        //check the previous url
        if(str_replace(url('/'), '', url()->previous())=="/profile"){
            return redirect()->route('profile')->with($notification);
        }else{
            return redirect()->route('home')->with($notification);
        }


    }


    public function RemoveTag($id){

        $post = Post::find($id);

        //remove only the user who want to remove the tag of this post
        $remove=[];
            foreach($post->users as $tag){  
                if(auth::id()!=$tag->id){
                $remove[]= $tag->id;
                }
            }
        $post->save();
        $post->users()->sync($remove);

            //-----insert activity----//
        $activity = new Activity;
        $activity->auth_id = Auth::id();
        $activity->user_id = $post->user_id;
        $activity->activity_status = '12'; //remove tag
        $activity->save();

        $notification = array(
            'message' => 'Remove Tag Successfully',
            'alert-type' => 'success'  //success variable came from admin.blade.php in java script toastr
        );

        //check the previous url
        if(str_replace(url('/'), '', url()->previous())=="/profile"){
            return redirect()->route('profile')->with($notification);
        }else{
            return redirect()->route('home')->with($notification);
        }

    }


}
