


<!--i include this in news feed -->

<style>
.write-post-area{
	border:0;
	outline: 0;
	border-bottom: 1px solid #ccc;
	resize: none;

}	

.avatar {
  vertical-align: middle;
  width: 60px;
  height: 60px;
  border-radius: 50%;
}
</style>



	<form method="post" action="{{ route('post_store')}}" enctype="multipart/form-data">
	@csrf
			<div class="write-post d-flex mt-4 rounded-2" style="background: white;" >	

				<div class="write-post-left-side ps-3 pt-2" >
					@if(!empty(auth()->user()->profile_photo))
						<img src="{{url('/upload/profile/'.auth()->user()->profile_photo)}}" class="avatar">
					@else
						<img src="/upload/profile/profile.jpg" class="avatar">
					@endif	
				</div><!--write-post-left-side-bar-->							

				<div class="write-post-right-side ps-2 pt-2">
					<div>
						<textarea  name="content" rows="3" cols="65" class="write-post-area" placeholder="What's on your mind?..."></textarea> 
			    	</div>

			    	<div class="d-flex" style="width: 500px;">
			    		<div style="width:100px;">
							<select name="feeling" id="feeling" >
							   <option value="">Feeling</option>
							 @foreach($feeling as $data)  
							   <option value="{{$data->id}}" data-icon="{{$data->icon_name}}">{{$data->name}}
							  @endforeach 	
							</select>	
						</div>

						<div style="padding-left: 50px;" >
				    		<label class="btn btn-light">
				    		    <i class="fas fa-images"></i>
				    		     Photo<input type="file" name="image" id="image" hidden>
				    		</label>
			    		</div>

			    		<div>
			    			<img src="" id="showimage"style="width: 50px">
			    		</div>
			    		
			    		<div class="ms-5">
							<select class="form-select form-select-sm" id="select" name="post_status" style="width: 123px;">	  
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

						<select class="tagg_friend" name="tagg_friend[]" multiple="multiple" style=" width: 300px;">
							<!--this variable came from appserviceprovider-->
							@foreach($all_friends_of_current_user as $user)
							  <option value="{{$user->id}}">{{$user->name}}</option>
							 @endforeach 
						</select>
					</div>
						@error('content')
						<span class="text-danger">*You need to write something</span>
						@enderror
			    	<div class="pb-2 pt-2">
			    		<input type="submit" class="btn btn-primary btn-sm" value="Post">
			    	</div>	

				</div><!--write-post-right-side-->
			</div><!--write-post-->
	</form>





