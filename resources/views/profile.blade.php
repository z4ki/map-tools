@extends('layout/dashboard_layout')
		@section('content')

		<style type="text/css">
			.avatar {
				width:100px!important;
				height: 100px;
			}
		</style>

		@if(Auth::check())
		<div class="row">
			 <div class="col s3 avatar">
			 	<img src="{{Storage::url('avatars/'. Auth::user()->avatar)}}">
			 </div>
		</div>
		@endif

		@endsection 