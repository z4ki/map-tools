@extends('layout/dashboard_layout')

		@section('content')
		<style type="text/css">
			input {
				border-bottom :1px solid #e91e63!important;
				
			}
			input:focus{
				
				border-bottom :2px solid #e91e63!important;
				box-shadow: 0 1px 0 0 #26a69a!important;

			}
		</style>
		<div class="row">
			<form class="col s8" enctype="multipart/form-data" action="/profile/edit/{{$user['id']}}" method="post">
				{{ csrf_field() }}
				<div class="row">
					<div class="input-field col s12 ">
			          <h3 class="pink-text"><i class="material-icons">settings</i>&nbsp<b>edit {{ $user['last_name'] }}'s Profile </b></h3>
			        </div>
					<div class="input-field col s12 ">
			          <input value="{{ $user['first_name'] }}" id="first_name" name="first_name" type="text" class="validate">
			          <label for="first_name">First Name</label>
			        </div>
			        <div class="input-field col s12">
			          <input value="{{  $user['last_name']  ? $user['last_name'] : 'lastname'  }}" id="last_name" type="text" class="validate" name="last_name">
			          <label for="last_name">Last Name</label>
			        </div>
			        <div class="input-field col s12">
			          <input value="{{ $user['email'] }}" id="email" type="email" name="email" class="validate">
			          <label for="email">email</label>
			        </div>
			        <div class="input-field col s12">
			          <input placeholder="******" id="password" type="password" name="password" class="validate">
			          <label for="password">Password</label>
			        </div>
			        <div class="input-field col s12">
			          <input placeholder="******" id="password_confirmation" type="password" name="password_confirmation" class="validate ">
			          <label for="password_confirmation">Password confirmation</label>
			        </div>
			        
					    <div class="file-field input-field col s12 ">
					      <div class="btn col s1 pink">
					        <span>...</span>
					        <input type="file" class="pink" name="avatar">
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate" type="text" placeholder="image path">
					      </div>
					    </div>
					  
					  <button id="save" type="submit" class="btn right pink col s3">Save changes</button>
				</div>	<!-- end Row -->
			</form>
		</div><!-- end row -->
	
		 <script type="text/javascript">
				$('.active').removeClass();
		    	$('#settings').addClass('active');
		</script> 
		@endsection