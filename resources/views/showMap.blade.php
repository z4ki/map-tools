@extends('layout.layout')

@section('content')
	<style type="text/css">
	body {
            background-color: #f8f8f8!important;
        }	
	#map {
   z-index: 10;
   height: 450px!important;
   width: 850px!important;
   margin-bottom: 5px!important;
   margin-top: 10px!important;
   }
   #h-bar button {
   padding: 0 5px!important;
   /*color:#000!important;*/
   }
   /* Color Palette Css*/
   .color {
   width: 25px!important;
   height: 25px!important;
   /*background-color: #388e3c!important;*/
   margin-right: 10px!important;
   margin-bottom: 5px!important;
   /*display: block;*/
   border-radius: 50px;
   }
   .color:hover {
   -moz-box-shadow: 0px 1px 10px 2px #ccc;
   -webkit-box-shadow: 0px 1px 10px 2px #ccc;
   box-shadow: 0px 1px 10px 2px #ccc;
   border-radius: p5x;
   }
   #color-palette {
   /*display: none!important;*/
   padding-top: 10px;
   max-width: 175px!important;
   max-height: 100px!important;
   margin: 25px 25px;
   /*background-color: #fcfcfc!important;*/
   }
   #color-palette ul {
   /*background-color: #fff!important;*/
   }

   #search-box {
            height: 3rem!important;
            margin-left: 5px!important;
            margin-bottom: 1rem!important;
            margin-top: 3.5rem!important;
            max-width: 500px!important;
            background-color: #fff!important;
            /*border-radius: 15px;*/
        }
        
        input[type=search] {
            background-color: #fff!important;
            border-bottom: none!important;
            margin: 5px 30px!important;
            padding-left: 2.5rem!important;
            height: 3rem!important;
        }
        #search-box i {
        	line-height: 15px!important;
        	margin-right:20px!important;
        	height: 20px!important;
        }
        input[type=search]:focus,
        input[type=search]:hover {
            background-color: #fff!important;
        }

#container {
	margin-left: 280px!important;
}

	</style>

	
	
	<div id="container" class="container">
	<div class="section col s6">
	   <div id="search-box" class="input-field  white ">
	      <input id="searchbar" type="search" placeholder="Search by place name" class="white black-text ">
	      <label class="label-icon white" for="search"><i class="material-icons ">search</i></label>
	   </div>
	</div>
    <div class="row">
    	<div id="map" class="col s11 z-depth-1 "></div>
	    <div id="bar" class="col s1 ">
	         <ul>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	            <li class="color z-depth-1"></li>
	         </ul>
	      </div>
    </div>	
    <div class="row">
    	<ul class="collection with-header">
	        <li class="collection-header"><h4>First Names</h4></li>
	        <li class="collection-item">Alvin skldfmsjdf mlskjdf sfjd mlkqsfjd mlqskfdj mqslfj.</li>
	        
	      </ul>
    </div>
	</div>
	





@endsection
@section('scripts')
<script 
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUX7u8kULgOdFAz-_iJbKb-o0miLfEbb4&libraries=drawing,places,geometry&callback=initMap"
   async defer></script>
<script type="text/javascript" src="/js/html2canvas.js "></script>
<script type="text/javascript " src="/js/mapster2.js "></script>
	<script type="text/javascript">
		$.get(window.location.pathname,
			function(data){

				
			});
	</script>

@endsection