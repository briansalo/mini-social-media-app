@extends('admin.container')

@section('content')	

	@foreach($alldata as $key => $data)

		<div class="profile-photo d-flex m-3"style="background-color: white">
			<div class="profile-photo-left d-flex m-2" style="width: 75%; ">
			<div class="" style="background-color: black">
				@if(empty($data->profile_photo))
				<img src="/upload/profile/profile.jpg"  style=" background: white; width: 100px; height:100px">
				@else
				<img src="{{url('/upload/profile/'.$data->profile_photo)}}"  style=" background: white; width: 100px; height:100px">
				@endif
			</div>
			<div class=" ms-2" style="">
				<div style="font-size: 30px;">
				{{$data->name}}
				</div>
				<div>
					{{count($friends_of_each_user[$key])}} Friends
				</div>	
				<div>

				@foreach($friends_of_each_user[$key] as $friendsOfUser)
				@if(!empty($friendsOfUser->profile_photo))
				<img src="{{url('/upload/profile/'.$friendsOfUser->profile_photo)}}" class="rounded-circle" style="width: 30px; height:30px">
				@else
					<img src="/upload/profile/profile.jpg" class="rounded-circle" style="width: 30px; height:30px">
				@endif
				@endforeach
				</div>	

			</div>

			</div><!--profile photo lef-->	

			@if($friendship[$key]->isEmpty())
				<div  class="profile-photo-right"style="width:25%;">
					<div class="pt-4 pe-3" style="float: right;">
						<a href="{{ route('add_friend', $data->id)}}" class="btn btn-primary">
							<i class="fas fa-user-friends"></i>Add Friend
						</a>
					</div>	
				</div>	<!--profile-photo-right-->
			@else
				<div  class="profile-photo-right"style="width:30%;">
					<div class="pt-4 pe-3" style="float: right;">
						<a href="{{ route('cancel_friend_request', $data->id)}}" class="btn btn-danger">
							<i class="fas fa-user-friends"></i>Cancel Friend Request
						</a>
					</div>	
				</div>	<!--profile-photo-right-->
			@endif

		</div>	<!--profile-photo-->

	@endforeach
	
@endsection

 