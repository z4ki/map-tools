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
              <h3 class="pink-text"><i class="material-icons"><h3><b>person_add</b></h3></i><b>&nbsp;Add New Agent</b></h3>
                <div class="input-field col s12">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="first_name" type="text" class="validate black-text" name="first_name" required>
                  <label for="name">First Name</label>
                </div>

                <div class="input-field col s12 ">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="last_name" type="text" name="last_name" class="validate black-text">
                  <label for="last_name">Last Name</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">email</i>
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
                  <i class="material-icons prefix">enhanced_encryption</i>
                  <input id="password"  name="password" type="password" class="validate black-text" required>
                  <label for="password" name="password" >Password</label>
                </div>
                <div class="input-field col s6">
                  <input id="password_confirmation"  name="password_confirmation" type="password" class="validate black-text" required>
                  <label for="password_confirmation" name="password_confirmation">Password Confirmation</label>
                </div>
                <div class="col s6">
                  
                  
                <div id="wrong-recaptcha" class="red-text lighten-2 "></div>
                </div>
                

               
                <button class="btn  waves-effect waves-light   pink col s3 z-depth-3 right" type="submit"><span class="white-text" >Add</span> </button>
              </div>
              @if($flash =session('message'))
              <script type="text/javascript">
                
                Materialize.toast('{{$flash}}', 4000);
              </script>
              

              @endif
              @include('errors')
            </form>


            <script src='https://www.google.com/recaptcha/api.js'></script>
            <script type="text/javascript">
              $('.active').removeClass();
              $('#new-agent').addClass('active');
              </script>

		@endsection