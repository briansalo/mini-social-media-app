@extends('admin.container')

@section('content')	

	@foreach($alldata as $key => $data)

		<div class="d-flex m-3"style="background-color: white">
			<div class="pic_name_friends_field d-flex m-2" style="width: 75%; ">
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
			</div><!--pic_name_friends_field-->	

			@if($friendship[$key]->isEmpty())
				<div  class="button_field"style="width:25%;">
					<div class="pt-4 pe-3" style="float: right;">
						<a href="{{ route('add_friend', $data->id)}}" class="btn btn-primary">
							<i class="fas fa-user-friends"></i>Add Friend
						</a>
					</div>	
				</div>	<!--button_field-->
			@else
				<div  class="button_field"style="width:30%;">
					<div class="pt-4 pe-3" style="float: right;">
						<a href="{{ route('cancel_friend_request', $data->id)}}" class="btn btn-danger">
							<i class="fas fa-user-friends"></i>Cancel Friend Request
						</a>
					</div>	
				</div>	<!--button_field-->
			@endif

		</div><!--d-flex-->

	@endforeach
	
@endsection

 