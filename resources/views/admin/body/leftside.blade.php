	
		<div class="col-md-3" style=" height: calc(100vh - 56px);
			  position: sticky; top: 50px;">

			<div class="important-links mt-2 ml-2">
				<div class="mb-3 mt-4 ms-5">
					<a href="{{ route('home') }}"><img src="/icons/images.png">Home</a>
				</div>
				<div class="mb-2 ms-5">
					 <a href="{{ route('list_of_user') }}"><img src="/icons/add_friend.png">Add Friend</a>
				</div>
				<div class="mb-4 ms-5">
					<a class="position-relative"href="{{ route('friend_request') }}"><img src="/icons/friend_request.png">
						<!--the variable came from appserviceprovider-->
						 @if(!count($friend_request) == 0)	
							  <span class="position-absolute  right-100 start-100 translate-middle badge rounded-pill bg-danger">
		    						{{count($friend_request)}}
		  					  </span>
	  					  @endif
  					  Friend Request  
  					  </a>
				</div>

				<div class="mb-3 ms-5">
					<a href="{{ route('list_of_friend') }}"><img src="/icons/friend_list.png">Friend List</a>
				</div>
				<div class="line ms-5"  style="background-color:black;">
				</div>

			</div><!--close important links -->

 	<div class="mt-2 ps-5">
 		<h5>Your Latest Activity:</h5>
	<ul class="list-group">
	@foreach($activities as $activity)

		@switch($activity->activity_status)
			@case(1)
		  		<li class="list-group-item list-group-item-danger">You Create a post</li>
		  		@break
		  	@case(2)
		  		<li class="list-group-item list-group-item-danger">You update a post</li>
		  		@break
		  	@case(3)
		  		<li class="list-group-item list-group-item-danger">You delete a post</li>
		  		@break
		  	@case(4)
		  		<li class="list-group-item list-group-item-danger">You sent a friend request to <i><u>{{$activity->user_info->name}}</u></i></li>
		  		@break
		  	@case(5)
		  		<li class="list-group-item list-group-item-danger">You cancel your friend request to <i><u>{{$activity->user_info->name}}</u></i></li>
		  		@break
		  	@case(6)
		  		<li class="list-group-item list-group-item-danger">You accept a friend request from <i><u>{{$activity->user_info->name}}</u></i></li>
		  		@break
		  	@case(7)
		  		<li class="list-group-item list-group-item-danger">You did not accept <i><u>{{$activity->user_info->name}}</u></i></li>
		  		@break
		   	@case(8)
		  		<li class="list-group-item list-group-item-danger">You Unfriend <i><u>{{$activity->user_info->name}}</u></i></li>
		  		@break
		  	@case(9)
		  		<li class="list-group-item list-group-item-danger">You Like <i><u>{{$activity->user_info->name}}</u></i> post</li>
		  		@break
		  	@case(10)
		  		<li class="list-group-item list-group-item-danger">You Unlike <i><u>{{$activity->user_info->name}}</u></i> post</li>
		  		@break
		  	@case(11)
		  		<li class="list-group-item list-group-item-danger">You Stalk <i><u>{{$activity->user_info->name}}</u></i></li>
		  		@break
		  	@case(12)
		  		<li class="list-group-item list-group-item-danger">You remove tag from<i><u>{{$activity->user_info->name}}</u></i> post</li>
		  		@break
		 @endswitch 	 	  	

	  @endforeach    
	</ul>
	</div>
</div><!-- left-side-bar--->