@extends('layout.layout')

@section('content')
	<style type="text/css">	
		#map {
   z-index: 10;
   height: 450px!important;
   width: 850px!important;
   margin-bottom: 5px!important;
   margin-top: 15px!important;
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
            background-color: #fff!important;
            /*border-radius: 15px;*/
        }
        
        input[type=search] {
            background-color: #fff!important;
            border-bottom: none!important;
            margin: 5px 0!important;
            padding-left: 2.5rem!important;
            height: 2.5rem!important;
        }
        
        input[type=search]:focus,
        input[type=search]:hover {
            background-color: #fff!important;
        }

	</style>
	<br><br><br>
	<div class="row">
	<div id="" class="">
	<div class="section col s8">
	   <div id="search-box" class="input-field  white ">
	      <input id="searchbar" type="search" placeholder="Search by place name" class="white">
	      <label class="label-icon white" for="search"><i class="material-icons ">search</i></label>
	   </div>
	</div>
    <div class="row">
    	<div id="map" class="col s10 z-depth-1"></div>
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
	</div>
	</div>





@endsection
@section('scripts')
	<script type="text/javascript">
		(function() {
        
        var palette = [
            "#f44336",
            "#e91e63",
            "#9c27b0",
            "#2196f3",
            "#03a9f4",
            "#009688",
            "#4caf50",
            "#cddc39",
            "#ff5722",
            "#795548",
            "#607d8b"
        ];


        var i = 0;
        var bar = $('.color');
        /*console.log(bar);*/
        $(".color").each(function() {

            $(this).css("background-color", palette[i]);
            $(this).attr("id", palette[i]);


            $(this).on("click", function() {
                fillColor = $(this).attr("id");

                drawingManager.setOptions({
                    circleOptions: {
                        fillOpacity: 1,
                        fillColor: fillColor
                    },
                    polygonOptions: {
                        fillOpacity: 1,
                        fillColor: fillColor
                    },
                    polylineOptions: {
                        fillOpacity: 1,
                        fillColor: fillColor
                    },
                    rectangleOptions: {
                        fillOpacity: 1,
                        fillColor: fillColor
                    }
                });


            });
            i++;
        });
    }());
	</script>

@endsection