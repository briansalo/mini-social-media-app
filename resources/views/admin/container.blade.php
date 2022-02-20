<!DOCTYPE html>
<html>
<head>
	<title>Mini Social Media</title>
    <link rel="icon" href="css_login/images/login2.jpg" type="image/x-icon" />
    
<!-------------for bootstrap 5----------->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


<!--------------for ajax and jquery ------------->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!--------------select 2------------->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!------------for icons----------->
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<script src="https://use.fontawesome.com/a2697fda3c.js"></script>
<script src="https://kit.fontawesome.com/5cffec2ddd.js" crossorigin="anonymous"></script>


<!------------ for toaster notification------------------>
	 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<!--for vue-->
	<script src="{{ asset('js/app.js') }}" defer></script>

<style>
.important-links a, .latest-post p{
	text-decoration: none;
	color: #626262;
}	
.important-links a img{
	width: 55px;
	margin-right: 5px;
}


.line{
	border-bottom: 2px solid #ccc;
}


.list-user-scroll{
height: 100px;
overflow-y: scroll;
position: sticky;
top: 0;   
 }


</style>
</head>
<body>

<!-- Modal if the screen is small -->
<div class="modal fade" id="forSmallScreen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Note:</h5>

      </div>
      <div class="modal-body">
        <h5>As of now, this application is not applicable for small screen. 
        	<br>We highly suggest to use laptop or computer</h5>
        

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><Br>

      </div>
    </div>
  </div>
</div>
<div class="container-fluid" style="background: #efefef;">
	<!-- navbar-->
	@include('admin.body.navbar')

		<div class="row">

				<!-- left sidebar-->
				@include('admin.body.leftside')

				<!-- main content-->
				<div class="col-md-6 px-4 pb-3">

					@yield('content')
				</div>

				<!-- right sidebar -->
				@include('admin.body.rightside')
					
		</div><!-- row-->

</div><!-- container-->



<script>

$(document).ready(function() {


	$(window).scroll(_.debounce(function(){
	
	    	 $.ajax({
		  				url: "{{ route('monitor.user.scroll')}}",
		   				method:'GET',
		  			  success:function(data){

		  				 }//success function
	  			})// end of ajax

	}, 250, { 'leading': true, 'trailing': false }));


    // This will fire when document is ready:
    $(window).resize(function() {
        // This will fire each time the window is resized:
        if($(window).width() >= 1000) {
            // if larger or equal
            $('#forSmallScreen').modal('hide');
        } else {
        	$('#forSmallScreen').modal('show');
            // if smaller
           // $("#for_desktop").attr('class', '');
            //$("#for_margin").attr('class', 'card mt-5 mb-5');
        }
    }).resize(); // This will simulate a resize to trigger the initial run.





    $('.tagg_friend').select2();

    $('.tagg_friend_modal').select2({
    	dropdownParent: $("#edit_post_modal")//this will help to retrieve the data in modal
    });



//---------for upload image--------------//
			$('#image').change(function(e){
				var reader = new FileReader();
				reader.onload = function(e){
					$('#showimage').attr('src',e.target.result);
				}
				reader.readAsDataURL(e.target.files['0']);
				
			});

//----------for upload images in modal---------------//
	$('#image-modal').change(function(e){
				var reader = new FileReader();
				reader.onload = function(e){
					$('#showimage-modal').attr('src',e.target.result);
					$('#close').removeClass('d-none');
				}
				reader.readAsDataURL(e.target.files['0']);
				
			});

//---------------for emoji in select-----------------//
		      function formatText (icon) {
		    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
		};

		$('#feeling').select2({
		    width: "100%",
		    templateSelection: formatText,
		    templateResult: formatText
		});

		$('#edit-feeling').select2({
			dropdownParent: $("#edit_post_modal"), //this will help to retrieve the data in modal
		    width: "100%",
		    templateSelection: formatText,
		    templateResult: formatText
		});


		/// -----------FOR TOASTER NOTIFICATION---------------//
		 @if(Session::has('message'))
		 var type = "{{ Session::get('alert-type','info') }}"
		 switch(type){
		    case 'info':
		    toastr.info(" {{ Session::get('message') }} ");
		    break;

		    case 'success':
		    toastr.success(" {{ Session::get('message') }} ");
		    break;

		    case 'warning':
		    toastr.warning(" {{ Session::get('message') }} ");
		    break;

		    case 'error':
		    toastr.error(" {{ Session::get('message') }} ");
		    break; 
		 }
		 @endif 


});//document ready
</script>



</body>
</html>