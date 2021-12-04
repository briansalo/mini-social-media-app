@extends('admin.container')

@section('content')	
	@if($alldata->isEmpty())
	<div>
		Nothing to Show
	</div>
	@else
	hello
	@endif
	@foreach($alldata as $key => $data)

		<div class="profile-photo d-flex m-3"style="background-color: white">
			<div class="profile-photo-left d-flex m-2" style="width: 70%">
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


				<div  class="profile-photo-right"style="width:30%;">
					<div class="pt-4 pe-3" style="float: right;">
						<a href="{{ route('accept_friend_request', $data->id)}}" class="btn btn-success">
							<i class="fas fa-user-friends"></i>Accept
						</a>
					</div>

					<div class="pt-1 pe-3" style="float: right;">
						<a href="{{ route('dont_accept_friend_request', $data->id)}}" class="btn btn-danger">
							<i class="fas fa-user-friends"></i>Don't Accept
						</a>
					</div>	
				</div>	<!--profile-photo-right-->

		</div>	<!--profile-photo-->

	@endforeach
	
@endsection

 