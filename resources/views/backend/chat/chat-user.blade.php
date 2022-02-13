@extends('admin.container')
@section('content')	

<div id="app">
	<chat-message 
	:authid="{{Auth::user()->id}}" 
	:receiverid="{{$receiver_id}}" 
	:authuser="{{auth::user()}}"
	:receiveruser="{{$receiveruser}}"
	></chat-message>
</div>

<script>
$(document).ready(function() {
    //if (window.location.href.indexOf('reload')==-1) {
      //   window.location.replace(window.location.href+'?reload');
    //}
});
</script>
@endsection