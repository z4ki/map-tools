@extends('layout/dashboard_layout')

		@section('content')
		<style>

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
    <form id="map-form" method="post" action="/dash/store">
      {{csrf_field()}}
		<div id="map" class="map ">
    			<!-- <img src="/img/850x450.png"> -->

    		
    </div>
    		<!-- Dropdown Trigger -->
    		<!-- <a class="dropdown-button btn right " style="margin-right:115px;" href="#" data-activates="dropdown1">Save as</a> -->
        <button id="save"  class="btn right" style="margin-right:115px;">Save</button>
    </form>

    		<!-- Dropdown Structure -->
    		<ul id="dropdown1" class="dropdown-content">
    		  <li><a href="#!">PDF</a></li>
    		  <li><a href="#!">PNG</a></li>
    		  <li><a href="#!">XML</a></li>
    		</ul>

		


		<div id="context-menu">
	      <ul class="collection">
	        <li class="collection-item">distance measurement</li>
	        <li class="collection-item">calculate surface</li>
	        <li class="collection-item">perimeter measurement</li>
	      </ul>
	    </div>

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

      </div>
      <br>
      <ul id="results" class="collection col s5">
          
      </ul>

      

      <script type="text/javascript" src="/js/mapster.js"></script>
      <script 
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUX7u8kULgOdFAz-_iJbKb-o0miLfEbb4&libraries=drawing&callback=initMap"
    async defer></script>












		@endsection
