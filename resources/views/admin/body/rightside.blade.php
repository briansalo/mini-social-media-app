		<div class="col-md-3" style="height: calc(100vh - 56px);
			  position: sticky; top: 50px;">
			<div class="new-register mx-2" style="background-color: white;"> 
			  	<div class="mt-4 ps-5" style="font-family: Times New Roman; font-size: 25px;">
			  		New User
			  	</div>
			  	<!--$latest_user variables came from appserviceprovider-->
			  @foreach($latest_user as $user)	
				<div class="mb-2" style="background-color: white;">
				  @if(!empty($user->profile_photo))
					<img src="{{url('/upload/profile/'.$user->profile_photo)}}" class="rounded-circle" style=" background: white; width: 15%; height: 50px;">  <a href="{{ route('stalk.profile', $user->id)}}">{{$user->name}}</a>
					@else
					<img src="/upload/profile/profile.jpg" class="rounded-circle" style=" background: white; width: 15%; height: 50px;">  <a href="{{ route('stalk.profile', $user->id)}}">{{$user->name}}</a>
				  @endif
				</div>	
			  @endforeach
			  
            </div><!--new register-->


            <div class="all-user pt-4 ps-2">
			  	<div class="mt-2 ps-5" style="font-family: Times New Roman; font-size: 25px;">
			  		All User
			  	</div>

			  	<div class="list-user-scroll" style="height: calc(55vh - 56px);
			  		position: sticky; top: 50px;">
	
			  @foreach($all_user as $user)
				<div class="mb-2" style="background-color: white">
				  @if(!empty($user->profile_photo))
					<img src="{{url('/upload/profile/'.$user->profile_photo)}}" class="rounded-circle ms-2 my-1" style=" background: white; width: 15%; height: 50px;"> <a href="{{ route('stalk.profile', $user->id)}}">{{$user->name}}</a>
					@else
					<img src="/upload/profile/profile.jpg" class="rounded-circle ms-2 my-1" style=" background: white; width: 15%; height: 50px;"> <a href="{{ route('stalk.profile', $user->id)}}">{{$user->name}}</a>
				  @endif
				</div>	
			 @endforeach
				</div>

			</div><!--all-user-->

		</div><!--col=md-3 right side bar-->	
