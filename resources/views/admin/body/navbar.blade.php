

<ul class="nav bg-primary sticky-top justify-content-between" style="height: calc(18vh - 56px);">


  <li class="nav-item pt-3 ps-3">
	 <!-- Example single danger button -->
	<div style="color: white;">
		Social Media App
	</div>	
  </li>

  <li class="nav-item  pt-3 pe-3 " >
	 <!-- Example single danger button -->
	<div class="btn-group ">
	  <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
	    <i class="fas fa-user-cog">  </i>
	  </button>
	  <div class="dropdown-menu dropdown-menu-end">
	    <a class="dropdown-item" href="#">{{Auth()->user()->name}}</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="{{route('profile')}}">My Profile</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="{{ route('log_out') }}">Log Out</a>
	  </div>
	</div>
  </li>
</ul>