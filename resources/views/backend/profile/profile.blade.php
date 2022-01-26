	@extends('admin.container')

@section('content')	

<style>

 /* for like and unlike link*/
.link-disabled{
	text-decoration: none;
	color: #626262;
	  pointer-events: none;
  cursor: default;
}

 /*for cover photo */
.cover_photo {
  position: relative;
  top: 0;
  left: 0;
}
.image1 {
  position: relative;
  top: 0;
  left: 0;

}
.image2 {
  position: absolute;
  bottom: 20px;
  right: 10px;
  border: 1px black solid;
}

 /*for profile photo */
.profile_photo {
  position: relative;
  top: 0;
  left: 0;
}
.profile1 {
  position: relative;
  top: 0;
  left: 0;

}
.profile2 {
  position: absolute;
  bottom: -10px;
  right: 35px;
  border: 1px black solid;
}

 /* for write post*/
.write-post-area{
	border:0;
	outline: 0;
	border-bottom: 1px solid #ccc;
	resize: none;
}	

 /* for close button when you upload image*/
.for_close_image {
  position: relative;
  top: 0;
  left: 0;
}
.close_image {
  position: relative;
  top: 0;
  left: 0;

}
.close_button {
  position: absolute;
  top: -5px;
  right: -5px;
  border: 1px black solid;
  
}

</style>

<!-- Edit Modal -->
<div class="modal fade" id="edit_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
 
	<form method="post" action="{{ route('post_update')}}" enctype="multipart/form-data">
	@csrf
			<div class="write-post d-flex rounded-2" style="background: white;" >	
		
				<div class="write-post-right-side ps-2 pt-2">
					<div>
						@error('text_post')
						<span class="text-danger">You need to write a post</span>
						@enderror
						<textarea  name="content" id="content" rows="3" cols="55" class="write-post-area" placeholder="What's on your mind?..."></textarea> 
			    	</div>

			    			<!--this will help what post would be edit-->
			    		<input type="hidden" name="post_id" id="post_id" value="">
			    		<!--if the image is close then delete the image in database-->
			    		<input type="hidden" name="check_image" id="check_image" value="">


			    	<div class="d-flex" style="width: 500px;">
			    		<div style="width:100px;">
							<select name="feeling" id="edit-feeling" >
							   <option value="">Feeling</option>
							 @foreach($feeling as $data)  
							   <option value="{{$data->id}}" data-icon="{{$data->icon_name}}">{{$data->name}}
							  @endforeach 	
							</select>	
						</div>

						<div class="for_close_image"style="padding-left: 50px;" >
				    		<label class="btn btn-light">
				    		    <i class="fas fa-images"></i>
				    		     Photo<input type="file" name="image" id="image-modal" hidden>
				    		</label>
		    		</div>

		    		<div class="for_close_image">
			    			<img src="" class="close_image" id="showimage-modal"style="width: 50px">
					       <a class="close_button btn-close" id="close" style="background-color: red; width: 5px; height:7px"></a>		    	
					   </div>

			    		<div class="ms-5">
							<select class="form-select form-select-sm" id="post_status" name="post_status" style="width: 120px;">	  
								@foreach($post_status as $data)  
								  <option value="{{$data->id}}">{{$data->name}}</option>
								@endforeach
							</select>
			    		</div>	
			    	</div><!--d flex--->	
			   

			    	<div style="padding-top: 10px;">
			    		<i class="fas fa-users me-2"></i>Tag Friends:
			    	</div>	
			    	<div>

						<select class="tagg_friend_modal" name="tagg_friend[]" id="tag" multiple="multiple" style=" width: 300px;">
							<!--this variable came from appserviceprovider-->
							@foreach($all_friends_of_current_user as $user)
							  <option value="{{$user->id}}">{{$user->name}}</option>
							 @endforeach 
						</select>
					</div>

				</div><!--write-post-right-side-->
			</div><!--write-post-->

      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary " value="Save Changes">
      </div>
  </form>

    </div>
  </div>
</div>
<!-- end Edit Modal -->




<!-- Delete Post Modal -->
<div class="modal fade" id="delete_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

 		<form action="{{ route('delete.post.modal')}}" method="post" id="deletePost">
 			@csrf

 			<input type="hidden" name="post_id_delete" id="post_id_delete" value="">

      <div class="modal-body">
        Are you sure you want to delete this post?
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-danger " value="Yes">
        <button type="button" class="btn btn-primary"data-bs-dismiss="modal">No</button>
      </div>
    </form>
      
    </div>
  </div>
</div>
<!-- end Delete Modal -->


			<!--------------------------Profile and Cover Photo area------------------------------>
	<form method="post" action="{{ route('profile_update')}}" enctype="multipart/form-data">
	@csrf
		<div class="cover_photo pt-4">
				@if(!empty(auth()->user()->cover_photo))
				 	<img id="show_cover_image" class="image1"src="{{url('/upload/cover/'.auth()->user()->cover_photo)}}" 
				 	style="background: white; width: 100%; height: 230px;">
			 	@else
				 	<img id="show_cover_image" class="image1"src="upload/cover/cover_photo.png" 
				 	style="background: white; width: 100%; height: 230px;">
			 	@endif
				<label class="btn btn-light image2">
					 <i class="fas fa-camera"></i>
	    			   Change Cover Photo<input type="file" name="cover_photo" id="cover_image" hidden>
				</label>
		</div>

		<div class="profile-photo d-flex"style="background-color: ;">
			<div class="profile-photo-left d-flex m-2" style="width: 80%;">

				<div class="profile_photo" >
					@if(!empty(auth()->user()->profile_photo))
						<img id="show_profile_image" class="profile1" src="{{url('/upload/profile/'.auth()->user()->profile_photo)}}" 
						 style=" background: white; width: 110px; height:115px">
					 @else
						<img id="show_profile_image" class="profile1" src="upload/profile/profile.jpg" 
						 style=" background: white; width: 110px; height:115px">
					 @endif
		    		<label class="btn btn-light btn-sm profile2 rounded-circle">
					    <i class="fas fa-camera"></i>
					     <input type="file" name="profile" id="profile_image" hidden>
					</label>
				</div>

				<div class=" ms-2">
					<div style="font-size: 30px;">
					<input type="text" name="name" class="form-control form-control-sm"value="{{auth()->user()->name}}">
					</div>
					<div>
						<!--this variable came from appserviceprovider-->
				{{count($all_friends_of_current_user)}} Friends
					</div>	

					<div>
					@foreach($all_friends_of_current_user as $key => $friendsOfUser)
					

							@if(!empty($friendsOfUser->profile_photo))
								<img src="{{url('/upload/profile/'.$friendsOfUser->profile_photo)}}" class="rounded-circle" style="width: 30px; height:30px">
							@else
									<img src="/upload/profile/profile.jpg" class="rounded-circle" style="width: 30px; height:30px">
						 	@endif

					@endforeach
					</div>	

				</div>

			</div><!--profile photo lef-->	
	
			<div  class="profile-photo-right"style="width:20%;">
				<div class="pt-5">
					<input type="submit" value="Save Changes" class="btn btn-success">
				</div>	
			</div>	<!--profile-photo-right-->

		</div>	<!--profile-photo-->

	</form>

			<!--------------------------News Feed Area------------------------------>

		 @foreach($profile_post as $key => $data)
			<div class="news-feed mt-3 rounded-2 line" style="background: white;">
				<div class="news-feed-header justify-content-between d-flex ps-3 pt-2">
					<!--left-->
					<div class="d-flex">
						<div>
						@if(!empty($data->user_info->profile_photo))	
						<img src="{{url('/upload/profile/'.$data->user_info->profile_photo)}}" class="rounded-circle" style=" background: white; width: 50px; height:50px">
						@else
							<img src="upload/profile/profile.jpg" class="rounded-circle" style=" background: white; width: 50px; height:50px">						
						@endif
						</div>
						<div>
							<div style="font-size: 20px; ">
							  <strong>{{$data->user_info->name}}</strong>

							  <!--check if there's feeling in this post-->
							  @if($data->feeling_info !=null)
							   is <i class="{{$data->feeling_info->icon_name}}"></i> feeling {{$data->feeling_info->name}}  
							  @endif

			<!--------------------------Tagged Features------------------------------>

							  <!--if there's no tagged then don't show the with word-->
							  @if($data->users->count()!=0)
							  	with
							  @endif

							  <!--if the tagged is more than two then make it have a dropdown-->
							  @if($data->users->count()>=2)
										@for($i=0; $i<$data->users->count(); $i++)
											<!--get the name of first array-->
											@if($i ==0)
								  			<b>{{$data->users[$i]->name}}</b>
											@endif
										@endfor

									 	and
									 			<!--dropdown-->
						    			<a href="#" data-bs-toggle="dropdown" aria-expanded="false">{{$data->users->count()-1}} others
										  <div class="dropdown-menu dropdown-menu-end">
										  	@for($i=0; $i<$data->users->count(); $i++)
										  		<!--get the name of second array and the rest of array-->
										  		@if($i !=0)
										    	<a class="dropdown-item" href="#">{{$data->users[$i]->name}}</a>
										   		 @endif
										    @endfor
										  </div>
										</a>	

								<!--else just show the name of user that tagged-->
							   @else
								    @foreach($data->users as $tag)
										 <b>{{$tag->name}}</b>
									@endforeach
							  @endif
							</div>

							<div class="d-flex"style="font-size: 10px;">
								<div>{{$data->privacy_info->name}}</div>							
								<div>
								   <i class="fas fa-sort-down ps-1 pe-1" ></i>
							        {{$profile_date[$key]}}
							    </div>
							</div>
						</div>	
					</div>
					<!--right-->


					<div>
						  <a class="btn btn-light " data-bs-toggle="dropdown" aria-expanded="false">
		    				<i class="fas fa-ellipsis-h" ></i>
						  </a>
						  <div class="dropdown-menu dropdown-menu-end">
									@if(Auth()->user()->id == $data->user_info->id)
								    <a class="dropdown-item" id="edit_modal" data-id="{{$data->id}}">Edit</a>
								    <a class="dropdown-item" id="delete_modal" data-id="{{$data->id}}">Delete</a>
						    	@else
						    		<a class="dropdown-item" href="{{ route('remove.tag', $data->id)}}" >Remove Tagg</a>
						    	@endif
						  </div>
					</div>

				</div><!--news-feed-header-->


				<div class="news-feed-content ps-3 pe-3 ">
					<div class="text-content " >
				       {{$data->content}}
					</div>
					<div>
						@if(!empty($data->image))
							 <img src="{{url('upload/post/'.$data->image)}}" style=" background: white; width: 100%; height: 300px;">
						@endif
					</div>
					<div class="line pt-2 "></div>
					<div class="pt-2 pb-2">


		<!-----------------------LIKE and Unlke Features--------------------------->
						@if(in_array($data->id, $like))	
													<!--this data-id can help you in jquery to identify what is the id in every post -->
								<button class="btn btn-primary btn-sm me-2 far fa-thumbs-up like{{$data->id}}"  id="like" data-id="{{$data->id}}" value="unlike">Unlike </button>
						@else
								<button class="btn btn-primary btn-sm me-2 far fa-thumbs-up like{{$data->id}}"  id="like" data-id="{{$data->id}}" value="like">Like </button>											
						@endif		

							<!--i use this in jquery to determine how many like each post-->
								<input type="hidden" class="count{{$data->id}} btn btn-transparent" data-id="{{$data->id}}" value="{{$data->likes->count()}}">


	<!---------------------count and show the users that like for this post---------------------->
						@if($data->likes->count()==0)
										<!--the class for_count_0 here is for jquery-->
							    <a class="link-disabled for_count_0{{$data->id}}"></a>

						@elseif($data->likes->count()==1)
								 @foreach($data->likes as $like_this_post)
											 @if(Auth()->user()->id == $like_this_post->user->id)
											 			<!--the class for_count_1 is for jquery-->
														<a class="link-disabled for_count_1{{$data->id}} btn btn-transparent">You like this post</a>
												@else
															<!--the class for_count_1_else is for jquery-->
														<a class="link-disabled for_count_1_else{{$data->id}}"></a>
															<!--for dropdown-->
							    					<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							    						{{$data->likes->count()}} users like this post
													  		<div class="dropdown-menu dropdown-menu-end">
																	@foreach($data->likes as $like_this_post)										  	
														   			 	<a class="dropdown-item" href="#">{{$like_this_post->user->name}}</a>   	  
																	@endforeach									   		
														   </div>
													 </a>														
									  		@endif
									@endforeach

						@else 
									<!--if the cuurent user liked this post-->
									 @if(in_array($data->id, $like))
								 					<!--the class for_many_count is for jquery-->
							    			<a class="link-disabled for_many_count{{$data->id}}">You and</a>
							    			  <!--for dropdown-->
							    			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							    			  	{{$data->likes->count()-1}} users like this post
													  <div class="dropdown-menu dropdown-menu-end">
																@foreach($data->likes as $like_this_post)					
																		@if(Auth()->user()->id != $like_this_post->user->id)				  	
														    			<a class="dropdown-item" href="#">{{$like_this_post->user->name}}</a>
														    		@endif
																@endforeach									   		
													  </div>
											  </a>
										@else
													<!--the class for_many_count is for jquery-->
							    			<a class="link-disabled for_many_count{{$data->id}}"></a>
							    	   		<!--for dropdown-->
							    			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							    					{{$data->likes->count()}} users  like this post
													  <div class="dropdown-menu dropdown-menu-end">
																@foreach($data->likes as $like_this_post)									  	
													    	<a class="dropdown-item" href="#">{{$like_this_post->user->name}}</a>
																@endforeach									   		
													  </div>
												</a>	
														
										@endif
												
						@endif


					</div>	
				</div><!--news-feed-content-->	
			</div><!--news-feed-->			@endforeach




<script>

//for upload cover image
			$('#cover_image').change(function(e){
				var reader = new FileReader();
				reader.onload = function(e){
					$('#show_cover_image').attr('src',e.target.result);
				}
				reader.readAsDataURL(e.target.files['0']);
				
			});

	
//for upload profile image
			$('#profile_image').change(function(e){
				var reader = new FileReader();
				reader.onload = function(e){
					$('#show_profile_image').attr('src',e.target.result);
				}
				reader.readAsDataURL(e.target.files['0']);
				
			});



  $(document).on('click','#like',function(){
  	var post_id = $(this).data('id'); //get the data-id of the like
 
  	    var post = $('.like'+post_id).val();
  	    var count = $('.count'+post_id).val();
  	    
  	    	//check if the value of post is like or unlike
  	    	  if(post == "like"){

		  	    	  	if(count=="0"){
		  	    	  	 $('.for_count_0'+post_id).text("You like this post");
		  	    	  	}

		  	    	  	if(count=="1"){
		  	    	  		$('.for_count_1'+post_id).text("You like this post");
		  	    	  		$('.for_count_1_else'+post_id).text("You and");
		  	    	  	}
  	    	  	

  	    		   	   $('.like'+post_id).text('Unlike');
  	    		   	   $('.like'+post_id).val("unlike");

  	    		   	    $('.for_many_count'+post_id).text("You and");
  	    		   	  
					   			 $.ajax({
		  									url: "{{ route('like')}}",
		   									method:'GET',
		   									data:{'post_id':post_id},
		  								 	dataType:'json',
		  								  success:function(data){

		  								 }//success function
	  								})// end of ajax

  	    	 }else{

		  	    	  	if(count=="0"){

		  	    	  	 $('.for_count_0'+post_id).text("");
		  	    	  	}

		  	    	  	if(count=="1"){
		  	    	  				$('.for_count_1'+post_id).text("");
		  	    	  				$('.for_count_1_else'+post_id).text("");
		  	    	  	}
		  	    		   	 	$('.like'+post_id).text('Like');
		  	    		   		$('.like'+post_id).val("like");

			  	    		   	$('.for_many_count'+post_id).text("");

							   	 		$.ajax({
					  								url: "{{ route('unlike')}}",
					   								method:'GET',
					   								data:{'post_id':post_id},
					  							  dataType:'json',
					  						  	 success:function(data){

			  								 		}//success function
					  					})// end of ajax
  	    	 }//else

  }); // close of document on click


  $(document).on('click','#edit_modal',function(){
  	  	var post_id = $(this).data('id'); //get the data-id of the edit
 
					   	 $.ajax({
	  							url: "{{ route('edit.post.modal')}}",
	   								method:'GET',
	   								data:{'post_id':post_id},
	  								 dataType:'json',
	  								 success:function(data){

				   							$('#edit_post_modal').modal('show')

				    						if (data.image == null){   
				    								$('#showimage-modal').attr("src", "");
				    								$('#close').addClass('d-none');
				    						}else{
				    								$('#showimage-modal').attr("src", "/upload/post/" + data.image);	
				    								$('#close').removeClass('d-none');		
				    						}

				    						$('#post_id').val(data.post_id);
				    						$('#content').attr("placeholder",data.content);
				    						$('#edit-feeling').val(data.feeling_id).change();
				    						$('#post_status').val(data.privacy_id).change();
				    						$('#tag').val(data.tagg_friend).change();

	  								 }//success function
  						})// end of ajax
  });



  $(document).on('click','#close',function(){

	  	$('#close').addClass('d-none');
	  	$('#showimage-modal').attr('src', "/upload/post/white.JPG");

  		$('#check_image').val("delete image");
  
  });	


   $(document).on('click','#delete_modal',function(){
  	  	var post_id = $(this).data('id'); //get the data-id of the edit

  	  	$('#post_id_delete').val(post_id);
		   		$('#delete_post_modal').modal('show')

	 });

</script>
@endsection