@extends('layout/dashboard_layout') @section('content')
<style>
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
   /* Light grey */
   border-top: 5px solid #000;
   /* Blue */
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
               <a href="#" id="modal-btn" class="modal-action modal-close waves-effect waves-green btn right">Done!</a>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Dropdown Structure -->
<!-- <ul id="dropdown1 " class="dropdown-content ">
   <li><a href="#! ">PDF</a></li>
   <li><a href="#! ">PNG</a></li>
   <li><a href="#! ">XML</a></li>
</ul> -->
<!-- <div id="h-bar ">
   <a href="# " id="polyline " class="btn white darken-2 " style="z-index:1000; ">
   <span class="black-text ">Lines</span>
   </a>
   <a href="# " id="polygon " class="btn white darken-2 " style="z-index:1000; ">
   <span class="black-text ">Polygon</span>
   </a>
   <a href="# " id="rectangle " class="btn white darken-2 " style="z-index:1000; ">
   <span class="black-text ">Rectangle</span>
   </a>
   <a href="# " id="circle " class="btn white darken-2 " style="z-index:1000; ">
   <span class="black-text ">Circle</span>
   </a>
   <a href="# " id="clear " class="btn white darken-2 " style="z-index:1000; ">
   <span class="black-text ">clear</span>
   </a>
   
   </div> -->
<script 
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUX7u8kULgOdFAz-_iJbKb-o0miLfEbb4&libraries=drawing,places,geometry&callback=initMap"
   async defer></script>
<script type="text/javascript " src="/js/mapster.js "></script>

<script type="text/javascript ">
   $(document).ready(function(){
       $('.modal').modal();
     });

  
   
   var projectName;
   var description;

   
   $("#modal-btn").on('click',function(){

     
     projectName = $('#project_name').val();
     description = $('#description').val();
     
     var spinner = '<div class="loader "></div>';
     $('#save-modal').append(spinner);
     $('#map-form').trigger('submit');
   
   });
   
   // $('.active').removeClass();
   $('#home').addClass('active');
   
</script>
@endsection