@extends('layout/dashboard_layout') @section('content')
<style>
#modal-btn {
   margin-top: 25px!important;
}
   .h-button a {
   margin-left: 5px!important;
   }
   /* BreadCrumb style*/
   nav {
   background-color: transparent!important;
   color: #000!important;
   }
   /**/
   .row {
   margin-bottom: 10px!important;
   }
   .collection-item {
   padding: 10px 0px 10px 10px!important;
   }
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
   #toast-container {
   top: 10px !important;
   right: 10px!important;
   }
   .btn {
   padding: 0 1rem!important;
   }
   #h-bar a:hover {
   font-weight: bold!important;
   }
   #wrong-captcha {
   margin-top: -15px!important;
   }


   /* for Spinner */
   .loader {
   margin-left: 5px;
   margin-right: 2px;
   display: inline-flex;
   border: 5px solid #fff;
   
   border-top: 5px solid #000;
  
   border-radius: 50%;
   width: 20px;
   height: 20px;
   animation: spin 2s linear infinite;
   }
   @keyframes spin {
   0% {
   transform: rotate(0deg);
   }
   100% {
   transform: rotate(360deg);
   }
   }

    /*This is just to center the spinner*/

/*html, body { height: 100%; }

body {
   display: flex;
   align-items: center;
   justify-content: center;
}*/

 /*Here is where the magic happens*/
/*
.spinner {
  animation: rotator 1.4s linear infinite;
}

@keyframes rotator {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(270deg);
  }
}
.path {
  stroke-dasharray: 187;
  stroke-dashoffset: 0;
  transform-origin: center;
  animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
}

@keyframes colors {
  0% {
    stroke: #fff;
  }
  25% {
    stroke: #fff;
  }
  50% {
    stroke: #fff;
  }
  75% {
    stroke: #fff;
  }
  100% {
    stroke: #fff;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 187;
  }
  50% {
    stroke-dashoffset: 46.75;
    transform: rotate(135deg);
  }
  100% {
    stroke-dashoffset: 187;
    transform: rotate(450deg);
  }
}*/
</style>
<div class="section">
   <div id="search-box" class="input-field  white col s6 ">
      <input id="searchbar" type="search" placeholder="Search by place name" class="white">
      <label class="label-icon white" for="search"><i class="material-icons ">search</i></label>
   </div>
</div>
<form id="map-form" method="post" action="/dash/store">
   {{csrf_field()}}
   <div class="row">
      <div id="map" class="col s11 z-depth-1"></div>
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
      <!-- Dropdown Trigger -->
      <!-- <a class="dropdown-button btn right " style="margin-right:115px;" href="#" data-activates="dropdown1">Save as</a> -->
   </div>
   <div class="row">
      <div class="h-button col s12">
         <a href="#modal1" id="save-modal" class="modal-trigger btn right" style="margin-right:115px;">Save</a>
         <a href="#" id="clear" class="btn white darken-2 right" style="z-index:1000;">
         <span class="black-text">clear</span>
         </a>
         <a href="#" id="redo" class="btn white darken-2 right" style="z-index:1000;">
         <i class="material-icons black-text">redo</i>
         </a>
         <a href="#" id="undo" class="btn white darken-2 right" style="z-index:1000;">
         <i class="material-icons black-text">undo</i>
         </a>
         <a href="#" id="screenshot" class="btn white darken-2 right" style="z-index:1000;">
         <i class="material-icons black-text">screen_share</i>
         </a>
      </div>
   </div>
</form>
<div id="modal1" class="modal col s5">
   <div class="modal-content">
      <div class="row">
         <div class="input-field col s6">
            <!-- <h6>Project Name</h6> -->
            <input id="project_name" type="text" class="validate" >
            <label for="project_name ">Project Name</label>
         </div>
         <div class="row ">
            <div class="input-field col s12 ">
               <textarea id="description" class="materialize-textarea"></textarea>
               <label for="description">Description</label>
               <div class="row">
                  <div class="input-field col s6">
                   <select id="state">
                     <option  value="Public">Public</option>
                     <option  value="Private">Private</option>
                   </select>
                 </div>
               <a href="#" id="modal-btn" class="modal-action modal-close waves-effect waves-green btn right col ">Done!</a>
               </div>
            </div>
            
         </div>
      </div>
   </div>
</div>

<script 
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUX7u8kULgOdFAz-_iJbKb-o0miLfEbb4&libraries=drawing,places,geometry&callback=initMap"
   async defer></script>
<script type="text/javascript" src="/js/html2canvas.js "></script>
<script type="text/javascript " src="/js/mapster.js "></script>

<script type="text/javascript ">
function ajaxSaving(){
    $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/dash/store',
            data: {
                "screenshot":img,
                "circles": CIRCLES,
                "polygons": POLYGONS,
                "rectangles": RECTANGLES,
                "polylines": POLYLINES,
                "projectName": projectName,
                "description": description,
                "state":$("#state").val(),
                "infoWindow": infoWindowArr,
            },

            success: function(data) {
                if (data === 'reCaptcha wrong') {
                    Materialize.toast('Please retry again !', 4000);
                    $('.modal').modal('open');
                } else {

                    Materialize.toast('Successfully Saved!', 4000);
                    $(".loader").fadeOut(400);
                    $("#save-modal").html('Saved!');
                    // var json = JSON.stringify(CIRCLES);
                    // var uri = encodeURIComponent(json);
                    // console.log(uri);
                    // var link = "data:json/plain;charset=utf-8," + uri;
                    // console.log(link);

                    // // var jj = uri.toDataUrl("text/plain")
                    // window.open(link,"_blank");
                }


            },
            error: function(data) {
                console.log("error", data);
                $(".loader").fadeOut(400);
                if (data === 'reCaptcha wrong') {
                    $('#wrong-captcha').html('Try to solve the reCaptcha again!');
                    grecaptcha().reset();
                    $('.modal').modal('open');
                }

            }
        });
}
   $(document).ready(function(){
      
       $('.modal').modal();
       $(document).ready(function() {
       $('select').material_select();
     });
     });

  
   
   var projectName;
   var description;
   var img;
function takeScreenshot(){
   html2canvas( $("#map") , {
        // allowTaint:true,
        logging: false,
        useCORS: true,
        onrendered: function (canvas) {

            img = canvas.toDataURL("image/jpeg");
            ajaxSaving();
            

         }
     });
}

   $("#screenshot").on('click',function(){

      takeScreenshot();

   });
   
   $("#modal-btn").on('click',function(){

     
     projectName = $('#project_name').val();
     description = $('#description').val();
     
     var spinner = '<div class="loader "></div>';

     // var spinner = '<svg class="spinner" width="35px" height="35px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">'+
     // +'<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>'
     // +'</svg>';
     $('#save-modal').append(spinner);

     
     $('#map-form').trigger('submit');
   
   });
   
   // $('.active').removeClass();
   $('#home').addClass('active');
   
</script>
@endsection