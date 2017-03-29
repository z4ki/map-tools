@extends('layout/dashboard_layout')

		@section('content')
    <style type="text/css">
      #wrong-recaptcha {
        margin-top : -12px!important;
      }
    </style>
		<form class="col s8" method="post" action="/register">
          {{ csrf_field()}}
              <div class="row">
              <h3 class="pink-text"><i class="material-icons"><h3><b>add</b></h3></i><b>Add New Agent</b></h3>
                <div class="input-field col s12">
                  <input id="first_name" type="text" class="validate black-text" name="first_name" required>
                  <label for="name">First Name</label>
                </div>

                <div class="input-field col s12 ">
                  <input id="last_name" type="text" name="last_name" class="validate black-text">
                  <label for="last_name">Last Name</label>
                </div>
                <div class="input-field col s6">
                  <input id="email" type="email" class="validate black-text"  name="email" required>
                  <label for="email"  name="email">Email</label>
                </div>
                <div class="col s6">
                  @if(Auth::user()->type =='admin') 
                  <div class="col s5">
                    <p>
                    <input class="with-gap" name="type" type="radio" id="isManager" value="manager" />
                    <label for="isManager">Manager</label>
                  </p>
                  </div>
                  @endif
                  <div class="col s3">
                  <p>
                    <input class="with-gap" name="type" type="radio" id="isAgent" value="agent" checked/>
                    <label for="isAgent">Agent</label>
                  </p>
                  </div>

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
                <div class="col s6">
                  
                  
                <div id="wrong-recaptcha" class="red-text lighten-2 "></div>
                <div class="g-recaptcha " data-sitekey="6LeCvBkUAAAAAJmeFRCBwI48W16gvRvRhoCOXuV8"></div>
                </div>
                

               
                <button class="btn  waves-effect waves-light   pink col s3 z-depth-3 right" type="submit"><span class="white-text" >Add</span> </button>
              </div>
              @include('errors')
            </form>


            <script src='https://www.google.com/recaptcha/api.js'></script>
            <script type="text/javascript">
            $.ajaxSetup({
	            headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	          });
            
            	$('button').on('click',function(e){
            		e.preventDefault();
                console.log('Posted');
            		$.ajax({
            			type:'POST',
            			url:'/register',
            			data:{
            				'first_name':$('#first_name').val(),
                    'last_name':$('#last_name').val(),
                    'type':$('input[name="type"]:checked').val(),
            				'email':$('#email').val(),
            				'password':$('#password').val(),
            				'password_confirmation':$('#password_confirmation').val(),
                     'captcha' :  grecaptcha.getResponse()

            			},
            			success:function(data){
            				if(data === 'reCaptcha'){
                      $('#wrong-recaptcha').html('please solve captcha again ! ');
                    }else{
            				Materialize.toast(data, 4000);
                    }
            			},
            			error:function(data){
            				console.log('error');
            			}
            		});
            	});
              
            </script>

		@endsection