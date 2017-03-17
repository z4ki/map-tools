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
    }
    #searchbar {
      background-color: #f8f8f8!important;
      margin-bottom: 10px!important;
      border-radius: 10px;
      /*padding: 0!important;*/
      /*height:44px!important;
      line-height: 44px!important;*/
    }
    #searchbar i {
      color:#444!important;
    }
    #search  {
      /*padding: 0!important;*/
      /*height:44px!important;*/
    }
    #search:focus {
      background-color: #f8f8f8!important;
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
    
    </style>
		<div class="section">
    
    <nav id="searchbar" class="col m8">
    <div class="nav-wrapper ">
      <form>
        <div class="input-field">
          <input id="search" type="search" required>
          <label class="label-icon" for="search"><i class="material-icons red-text">search</i></label>
          <i class="material-icons">close</i>
        </div>
      </form>
    </div>
  </nav>  
    </div>
    <form id="map-form" method="post" action="/dash/store" >
      {{csrf_field()}}
      <div class="row">
        
    
        <div id="map" class="col s11 "></div>
        <div id="bar" class="col s1 " >
            <ul>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>
              <li class="color"></li>

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
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUX7u8kULgOdFAz-_iJbKb-o0miLfEbb4&libraries=drawing&callback=initMap"
    async defer></script>

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


        
  
          


    </script>










		@endsection
