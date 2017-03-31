@extends('layout/dashboard_layout')

		@section('content')
		<style>
    .row {
      margin-bottom: 10px!important;
    }
    .collection-item {
      padding:10px 0px 10px 10px!important;
    }
    #context-menu {
      font-weight: 
      display: none;
      z-index: 1000;
      position: absolute;
    }
    .context-menu--active {
      display: block!important;

    }
    #map {
      z-index: 10;
      height :450px!important;
      width: 850px!important;
      margin-bottom: 5px!important;
      margin-top: 15px!important;
    }
    

    #h-bar button  {
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
      .color:hover{
        -moz-box-shadow:    0px 1px 10px 2px #ccc;
        -webkit-box-shadow: 0px 1px 10px 2px #ccc;
        box-shadow:         0px 1px 10px 2px #ccc;
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


      #search-box {

        height:3rem!important;
        margin-left: 5px!important;
        margin-bottom: 1rem!important;
        background-color: #fff!important;
        /*border-radius: 15px;*/
      }

      

      input[type=search]{
        background-color: #fff!important;
        border-bottom: none!important;
        margin:5px 0!important;
        padding-left: 2.5rem!important;
        height:2.5rem!important;
      }
      input[type=search]:focus,input[type=search]:hover{
        background-color: #fff!important;

      }
      #h-bar a:hover {
        font-weight: bold!important;
      }
      #wrong-captcha{
        margin-top : -15px!important;
      }
    
    </style>
		<div class="section">
    
    <!-- <nav id="searchbar" class="col m8">
    <div class="nav-wrapper "> -->
      
        <div id="search-box" class="input-field  white col s6 ">
          <input id="searchbar" type="search" placeholder="place name or latitude and langitude " class="white">
          <label class="label-icon white" for="search"><i class="material-icons ">search</i></label>
        </div>
      
    <!-- </div>
  </nav>   -->
    </div>
    <form id="map-form" method="post" action="/dash/store" >
      {{csrf_field()}}
      <div class="row">
        
    
        <div id="map" class="col s11 z-depth-1"></div>
        <div id="bar" class="col s1 " >
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
        <a href="#modal1" id="save-moal"  class="modal-trigger btn right" style="margin-right:115px;">Save</a>
      </div>
    </form>
    <div id="modal1" class="modal col s5">
      <div class="modal-content">
        <div class="row">
          <div class="input-field col s6">
          <h6>Project Name</h6>
          <input id="project_name" type="text" class="validate" placeholder="project name here ...">
          <label for="project_name"></label>
        </div>
        <div class="row">
        <div class="input-field col s12">
          <textarea id="description" class="materialize-textarea"></textarea>
          <label for="description">Description</label>
          <div id="wrong-captcha"></div>
          <div class="g-recaptcha" data-sitekey="6LeCvBkUAAAAAJmeFRCBwI48W16gvRvRhoCOXuV8"></div>
          <a href="#!" id="modal-btn" class="modal-action modal-close waves-effect waves-green btn  right ">Save!</a>
        </div>
        
      </div>
      
      </div>
      
    </div>
    		<!-- Dropdown Structure -->
    		<ul id="dropdown1" class="dropdown-content">
    		  <li><a href="#!">PDF</a></li>
    		  <li><a href="#!">PNG</a></li>
    		  <li><a href="#!">XML</a></li>
    		</ul>

		


      <div id="h-bar">
        <a href="#" id="polyline" class="btn white darken-2" style="z-index:1000;">
        <span class="black-text">Lines</span>
        </a>
        <a href="#" id="polygon" class="btn white darken-2" style="z-index:1000;">
        <span class="black-text">Polygon</span>
        </a>
        <a href="#" id="rectangle" class="btn white darken-2" style="z-index:1000;">
        <span class="black-text">Rectangle</span>
        </a>
        <a href="#" id="circle" class="btn white darken-2" style="z-index:1000;">
        <span class="black-text">Circle</span>
        </a>
        <a href="#" id="clear" class="btn white darken-2" style="z-index:1000;">
        <span class="black-text">clear</span>
        </a>
        
        

      </div>
      
      <br>
      <ul id="results" class="collection col s5">
          
      </ul>

      

      <script type="text/javascript" src="/js/mapster.js"></script>
      <script 
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUX7u8kULgOdFAz-_iJbKb-o0miLfEbb4&libraries=drawing,places&callback=initMap"
    async defer></script>
    <script async defer src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript">
      
      
        
$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });

var projectName;
var description;
$("#modal-btn").on('click',function(){
  projectName = $('#project_name').val();
  description = $('#description').val();
  $('#map-form').trigger('submit');
});

$('#search-box').mouseover(function(){
  console.log('mouseover');
  $(this).addClass('z-depth-2');
});

$('#search-box').mouseout(function(){
  $(this).removeClass('z-depth-2');
});
$('input[type=search]').focusin(function(){

  $('#search-box').addClass('z-depth-2');
});

        
  
          


    </script>










		@endsection
