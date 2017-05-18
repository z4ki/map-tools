@extends('layout.layout')

@section('content')
	<style type="text/css">
	
	</style>

	<br>
	<br>
	<br>
<div class="row">

     <div id="map-container" class="container">
     		@foreach($maps as $map)
     			<div class="col s4 ">
		          <div class="card z-depth-3">
		            <div class="card-image">
		              <img materialize="" class="materialboxed" src="/storage/mapScreenshot/{{ $map->screenshot}} ">
		              <span class="card-title grey-text text-darken-2"><b>{{ $map->project_name}} </b></span>
		            </div>
		            <div class="card-content">
		              <p>{{$map->description}} .</p>
		            </div>
		            <div class="card-action">
		              <a href="/map/show/{{$map->id}}" class="">Show Map!</a>
		            </div>
		          </div>
		        </div>
     		@endforeach	
     </div>

</div>




@endsection

@section('scripts')
<script type="text/javascript">
 $('.activated').removeClass();
 $('#maps').addClass('activated');
//  if($(window).height() > $("body").height()){
//    $("footer").css("position", "fixed");
// } else {
//    $("footer").css("position", "absolute");
// }
</script>

@endsection