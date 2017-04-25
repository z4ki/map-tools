@extends('layout/dashboard_layout')

		@section('content')

		<h2 class="pink-text darken-3 " >All sub-users !! </h2>

		<div id="Users" style="margin-top:50px;" >
		  <div id="search-box" class="input-field  white col s6 ">
		          <input id="searchbar" type="search" placeholder="Search by project name" class="white">
		          <label class="label-icon white" for="search"><i class="material-icons ">search</i></label>
		        </div>
		  

		    <table class="highlight">
		        <thead>
		          <tr>
		              <th data-field="firstname">First Name</th>
		              <th data-field="lastname">Last Name</th>
		              <th data-field="email">email</th>
		              <th data-field="type">type
		              </th>

		              <th data-field="created_at">Created at</th>

		              <th class="center-align " data-field="actions">Actions</th>
		          </tr>
		        </thead>

		        <tbody>
		         
		         
		          
		                  </tbody>
		      </table>
		</div>



		<script type="text/javascript">
		$('.active').removeClass();
    	$('#users').addClass('active');
			function populateTable(data){
				console.log(data);
	         for(var i=0;i<data.length;i++){

	      var table =  '<tr>'+
	                  '<td id="firstname">'+ data[i].first_name + '</td>'+
	                  '<td id="lastname">'+data[i].last_name+'</td>'+
	                  '<td id="email">'+data[i].email+'</td>'+
	                  '<td id="type">'+data[i].type+'</td>'+
	                  '<td id="created_at">'+data[i].created_at+'</td>'+


	                  '<td>'+
	                  '<a href="#" id="delete"><span class="new badge red" data-badge-caption="delete"></span></a>'+
	                  '<a href="" id="edit"><span class="new badge yellow" data-badge-caption="edit"></span></a>'+
	                  '<a href="profile/show/'+ data[i].id+  '"id="view"><span  class="new badge" data-badge-caption="view"></span></a>'+
	                  '</td></tr>';


	                  $("tbody").prepend(table);
	       
	      } 
	  }


	  $.get(
	  	window.location.origin + '/show/users',
	  	function (data){
	  		populateTable(data);
	  	}
	  	);
		</script>

		@endsection