@extends('layout/dashboard_layout')

		@section('content')
		<div class="section"></div>

		<div class="">
			<img src="/img/850x450.png">
		<br>

		<!-- Dropdown Trigger -->
		<a class="dropdown-button btn right" style="margin-right:115px;" href="#" data-activates="dropdown1">Save as</a>

		<!-- Dropdown Structure -->
		<ul id="dropdown1" class="dropdown-content">
		  <li><a href="#!">PDF</a></li>
		  <li><a href="#!">PNG</a></li>
		  <li><a href="#!">XML</a></li>
		</ul>

		</div>




		@endsection
