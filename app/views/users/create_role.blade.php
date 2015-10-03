@extends('layouts/default')

@section('content')

	<h3 class="page-title">
		Register New Role <small>form</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('users') }}">Users</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('roles') }}">Roles</a>
				<i class="fa fa-angle-right"></i>
			</li>	
			<li>
				Register
			</li>					
		</ul>
	</div>	

	{{ Form::open() }}

		<div class="form-group">

			{{ Form::label('role', 'Role', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-user"></i>
				{{ Form::text('role', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Role']) }}
			</div>
		</div>

		<div class="form-actions">

			<button type="submit" id="register-submit-btn" class="btn blue" data-confirm>
			Register <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}

@stop