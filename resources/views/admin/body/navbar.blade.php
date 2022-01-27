

<ul class="nav bg-primary sticky-top justify-content-between" style="height: calc(18vh - 56px);">


  <li class="nav-item pt-3 ps-3">
	 <!-- Example single danger button -->
	<div class="ps-5"style="color: white; font-family: Britannic Bold; font-size:25px;">
		Mini Social Media App
	</div>	
  </li>

  <li class="nav-item  pt-2 pe-3 " >
	 <!-- Example single danger button -->
	<div class="btn-group ">
	  <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
	    <i class="fas fa-user-cog"> {{ucwords(Auth()->user()->name)}} </i>
	  </button>
	  <div class="dropdown-menu dropdown-menu-end">
	    <a class="dropdown-item" href="{{route('profile')}}">My Profile</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="{{ route('log_out') }}">Log Out</a>
	  </div>
	</div>
  </li>
</ul>