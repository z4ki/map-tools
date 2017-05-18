@extends('layout/dashboard_layout')

		@section('content')

		<h2 class="pink-text darken-3 " >All sub-users !! </h2>

		<div id="Users" style="margin-top:50px;" >
		  <div class="row">
		  	<div id="search-box" class="input-field  white col s6 ">
		          <input id="searchbar" type="search" placeholder="Search by first name or last name" class="white">
		          <label class="label-icon white" for="search"><i class="material-icons ">search</i></label>
		  </div>
		  <div class="offset-s3">
		  <!--<a class="btn right"> <i class="material-icons">person_add</i>&nbsp;Add New</a> -->
		  <a href="/addAgent"  class="waves-effect waves-light btn right"><i class="material-icons left">person_add</i>Add New</a>
		  </div>
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
		$('title').html('All Projects');

$(document).on('click',function(e){
    // console.log(e);
  if(e.target.id === 'delete'){
    
    var id = e.target.dataset.id;
    $.ajax({
    type: 'POST',
    url: '/users/delete/' + id,
    data:1,
    success: function(data){
      if(data === 'deleted'){
        Materialize.toast('Deleted Successfully !', 4000);
        $('tr#'+id).fadeOut(400);
        $('tr#'+id).remove();
      }
    },
    error:function(data){
        console.log(data);
        Materialize.toast('There is an error !', 4000);

    }
    });

  }
});

		$('.active').removeClass();
    	$('#users').addClass('active');
			function populateTable(data){
				// console.log(data[0].avatar);
	         for(var i=0;i<data.length;i++){

	      var table =  '<tr id="'+  data[i].id +  '">'+
	                  '<td id="firstname">'+ data[i].first_name + '</td>'+
	                  '<td id="lastname">'+data[i].last_name+'</td>'+
	                  '<td id="email">'+data[i].email+'</td>'+
	                  '<td id="type">'+data[i].type+'</td>'+
	                  '<td id="created_at">'+data[i].created_at+'</td>'+


	                  '<td>'+
	                  '<a href="#" id="delete"><span id="delete" class="new badge red" data-badge-caption="delete" id="'+  data[i].id+  '"></span></a>'+
	                  '<a href="/profile/edit/'+ data[i].id +' " id="edit"><span class="new badge yellow" data-badge-caption="edit"></span></a>'+
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
	  $('#searchbar').focusin(function(){

        window.onkeyup = function(e){
  		if($('#searchbar').val() !=  ''){
          $.get(
            window.location.origin +'/users/search/' + $('#searchbar').val() ,
            function(data){
              $("tbody").html('');
               console.log(data)
              populateTable(data);
              
            }
            );
  		}

        }
      });
		</script>

		@endsection