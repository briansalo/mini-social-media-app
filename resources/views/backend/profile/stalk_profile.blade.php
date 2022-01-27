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
</style>

  <!--------------------------Profile and Cover Photo area------------------------------>
	<div class="pt-4">
				@if(!empty($stalk_profile->cover_photo))
				 	<img src="{{url('/upload/cover/'.$stalk_profile->cover_photo)}}" 
				 	style="background: white; width: 100%; height: 230px;">
			 	@else
				 	<img src="/upload/cover/cover_photo.png" style="background: white; width: 100%; height: 230px;">
			 	@endif

		</div>

		<div class="profile-photo d-flex"style="background-color: white">
			<div class="profile-photo-left d-flex m-2" >

					@if(!empty($stalk_profile->profile_photo))
						<img src="{{url('/upload/profile/'.$stalk_profile->profile_photo)}}" 
						 style=" background: white; width: 110px; height:115px">
					 @else
						<img src="/upload/profile/profile.jpg" style=" background: white; width: 110px; height:115px">
					 @endif
			

				<div class=" ms-2" style="">
					<div style="font-size: 30px;">
					{{ucwords($stalk_profile->name)}}
					</div>
					<div>
						{{count($get_all_friends)}} Friends
					</div>	

					<div>
					@foreach($get_all_friends as $key => $friendsOfUser)
				
							@if(!empty($friendsOfUser->profile_photo))
								<img src="{{url('/upload/profile/'.$friendsOfUser->profile_photo)}}" class="rounded-circle" style="width: 30px; height:30px">
							@else
									<img src="/upload/profile/profile.jpg" class="rounded-circle" style="width: 30px; height:30px">
						 	@endif

					@endforeach
					</div>	

				</div>

			</div><!--profile photo lef-->	
	

		</div>	<!--profile-photo-->



			<!--------------------------News Feed area------------------------------>
		 @foreach($profile_post as $key => $data)
			<div class="news-feed mt-3 rounded-2 line" style="background: white;">
				<div class="news-feed-header justify-content-between d-flex ps-3 pt-2">
					<!--left-->
					<div class="d-flex">
						<div>
						@if(!empty($data->user_info->profile_photo))	
						<img src="{{url('/upload/profile/'.$data->user_info->profile_photo)}}" class="rounded-circle" style=" background: white; width: 50px; height:50px">
						@else
							<img src="/upload/profile/profile.jpg" class="rounded-circle" style=" background: white; width: 50px; height:50px">						
						@endif
						</div>
						<div>
							<div style="font-size: 20px; ">
							  <strong>{{ucwords($data->user_info->name)}}</strong>

							  <!--check if there's feeling in this post-->
							  @if($data->feeling_info !=null)
							   is <i class="{{$data->feeling_info->icon_name}}"></i> feeling {{$data->feeling_info->name}}  
							  @endif

			<!--------------------------Tag Feature------------------------------>
							  <!--if there's no tagged then don't show the with word-->
							  @if($data->users->count()!=0)
							  	with
							  @endif

							  <!--if the tagged is more than two then make it have a dropdown-->
							  @if($data->users->count()>=2)
									@for($i=0; $i<$data->users->count(); $i++)
										<!--get the name of first array-->
										@if($i ==0)
							  			<b>{{ucwords($data->users[$i]->name)}}</b>
										@endif
									@endfor

								 	and

					    			<a href="#" data-bs-toggle="dropdown" aria-expanded="false">{{$data->users->count()-1}} others
									  <div class="dropdown-menu dropdown-menu-right">
									  	@for($i=0; $i<$data->users->count(); $i++)
									  		<!--get the name of second array and the rest of array-->
									  		@if($i !=0)
									    	<a class="dropdown-item">{{ucwords($data->users[$i]->name)}}</a>
									   		 @endif
									    @endfor
									  </div>
									</a>	

								<!--else just show the name of user that tagged-->
							   @else
								    @foreach($data->users as $tag)
										 <b>{{ucwords($tag->name)}}</b>
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
														<a class="link-disabled for_count_1{{$data->id}}">You like this post</a>
												@else
															<!--the class for_count_1_else is for jquery-->
														<a class="link-disabled for_count_1_else{{$data->id}}"></a>
															<!--for dropdown-->
							    					<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							    						{{$data->likes->count()}} users like this post
													  		<div class="dropdown-menu dropdown-menu-end">
																	@foreach($data->likes as $like_this_post)										  	
														   			 	<a class="dropdown-item">{{ucwords($like_this_post->user->name)}}</a>   	  
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
														    			<a class="dropdown-item">{{ucwords($like_this_post->user->name)}}</a>
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
													    	<a class="dropdown-item">{{ucwords($like_this_post->user->name)}}</a>
																@endforeach									   		
													  </div>
												</a>	
														
										@endif
												
						@endif

			  </div>	
			</div><!--news-feed-content-->	
		</div><!--news-feed-->		

	@endforeach

<script>

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
</script>	


@endsection