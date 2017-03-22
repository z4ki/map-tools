@extends('layout/dashboard_layout')

		@section('content')
		<form class="col s8" method="post" action="/register">
          {{ csrf_field()}}
              <div class="row">
              <h3 class="pink-text"><i class="material-icons"><h3><b>add</b></h3></i><b>Add New Agent</b></h3>
                <div class="input-field col s12">
                  <input id="name" type="text" class="validate black-text" name="name" required>
                  <label for="name">First Name</label>
                </div>

                <div class="input-field col s12 ">
                  <input id="last_name" type="text" class="validate black-text">
                  <label for="last_name">Last Name</label>
                </div>
                <div class="input-field col s6">
                  <input id="email" type="email" class="validate black-text"  name="email"required>
                  <label for="email"  name="email">Email</label>
                </div>
                
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <input id="password"  name="password" type="password" class="validate black-text" required>
                  <label for="password" name="password" >Password</label>
                </div>
                <div class="input-field col s6">
                  <input id="password_confirmation"  name="password_confirmation" type="password" class="validate black-text" required>
                  <label for="password_confirmation" name="password_confirmation">Password Confirmation</label>
                </div>
                <button class="btn  waves-effect waves-light yellow darken-2 z-depth-3 right" type="submit"><span style="color:#121212;">Add</span> </button>
              </div>
              @include('errors')
            </form>


            <script type="text/javascript">
            $.ajaxSetup({
	            headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	          });
            
            	$('button').on('click',function(e){
            		e.preventDefault();
            		$.ajax({
            			type:'POST',
            			url:'/register',
            			data:{
            				'name':$('#name').val(),
            				'email':$('#email').val(),
            				'password':$('#password').val(),
            				'password_confirmation':$('#password_confirmation').val()
            			},
            			success:function(data){
            				console.log(data);
            				Materialize.toast(data, 4000);
            			},
            			error:function(){
            				console.log('error');
            			}
            		});
            	});
            </script>

		@endsection