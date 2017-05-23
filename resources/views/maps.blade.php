@extends('layout.layout')

@section('content')
	<style type="text/css">
	.pagination .material-icons {
		line-height: 30px!important;
	}
	</style>

	<br>
	<br>
	<!-- <h4 class="grey-text text-darken-2" ><b>Public Maps</b></h4> -->
	<!-- <div class="divider"></div> -->
	<br>
<div class="row">
     <div id="map-container" class="container">
     		@foreach($maps as $map)
     			<div class="col s4 ">
		          <div class="card ">
		            <div class="card-image">
		              <img materialize="" class="materialboxed" src="/storage/mapScreenshot/{{ $map->screenshot}} ">
		              <span class="card-title grey-text text-darken-2"><b>{{ $map->project_name}} </b></span>
		            </div>
		            <div class="card-content">
		              <p>{{$map->description}}.</p>
		            </div>
		            <div class="card-action">
		              <a href="/map/show/{{$map->id}}" class=""><b>Show Map!</b></a>
		            </div>
		          </div>
		        </div>
     		@endforeach	

     </div>

</div>
     <div class="row">
     	<div class="center-align">
     	{{ $maps->links()}}
     		
     	</div>
     </div>

     <!-- <ul class="pagination"> -->
     	<!-- <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li> -->
 		<!-- <li class="disabled"><a href="#!"><i class="material-icons">chevron_right</i></a></li> -->
     <!-- </ul> -->




@endsection

@section('scripts')
<script type="text/javascript">
// var anchor  = $('ul.pagination li a').first().html(function(){
// 	if($(this).html() === '«'){
// 		$(this).html('<i class="material-icons">chevron_left</i>');
// 	}
// });
// $('ul.pagination li a').last().html(function(){
	
// 		$(this).html('<i class="material-icons">chevron_right</i>');
	
// });



// var anchor = $('ul.pagination li a').attr('rel',function(){
// 	if($(this).attr('rel') === 'prev'){
// 		$(this).html('<i class="material-icons">chevron_left</i>');
// 	}else if($(this).attr('rel') === 'next'){
// 		$(this).html('<i class="material-icons">chevron_right</i>');
// 	}
// });
// anchor.html('<i class="material-icons">chevron_left</i>');
 $('.activated').removeClass();
 $('#maps').addClass('activated');
 // $(".brand-logo").html('Public Maps')
//  if($(window).height() > $("body").height()){
//    $("footer").css("position", "fixed");
// } else {
//    $("footer").css("position", "absolute");
// }
</script>

@endsection