@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		Register Import Cargo <small>form</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('manifest.schedule') }}">Schedule</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ route('manifest.schedule.import', $schedule->id ) }}"> {{ $schedule->vessel->name}} v.{{ $schedule->voyage_no_arrival }}</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				Register
			</li>						
		</ul>
	</div>	

	{{ Form::open(['id' => 'form_cargo']) }}

		<div class="form-group">
			{{ Form::label('bl_no', 'B/L No', ['class' => 'control-label']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				{{ Form::text('bl_no', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'B/L No']) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('consignor_id', 'Consignor', ['class' => 'control-label']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-male"></i></span>			
				{{ Form::text('consignor_id','', ['id'=>'consignor_id','class'=>'form-control', 'data-placeholder'=>"Choose a Consignor..."]) }}
			</div>
		</div>		

		<div class="form-group">
			{{ Form::label('consignee_id', 'Consignee', ['class' => 'control-label']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-male"></i></span>			
				{{ Form::text('consignee_id','', ['id'=>'consignee_id','class'=>'form-control', 'data-placeholder'=>"Choose a Consignee..."]) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('mt', 'MT', ['class' => 'control-label']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-check"></i></span>
				{{ Form::text('mt', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'MT']) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('m3', 'M3', ['class' => 'control-label']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-check"></i></span>
				{{ Form::text('m3', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'M3']) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('description', 'Description', ['class' => 'control-label']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-check"></i></span>
				{{ Form::textarea('description', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Description', 'rows' => '3']) }}
			</div>
		</div>

		<div class="form-group">
			{{ Form::label('markings', 'Markings', ['class' => 'control-label']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-check"></i></span>
				{{ Form::textarea('markings', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Markings', 'rows' => '2']) }}
			</div>
		</div>

		<div class="form-actions">
			<button type="submit" id="register-submit-btn" class="btn blue" data-confirm>
			Register <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}

@stop

@section('page_level_plugins')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js') }}"></script>
@stop

@section('scripts')
ComponentsPickers.init();
ComponentsDropdowns.init();

	portUserPlugin('#consignor_id');
	portUserPlugin('#consignee_id');

	function portUserPlugin(inputName)
	{
		$(inputName).select2({
			minimumInputLength: 4,
			ajax: {
				url: '{{ route('workorders.handler_list') }}',
				quietMillis: 1000,
				type: 'GET',
				data: function (term, page) {
					return {
						q:term
					};
				},
				results: function (data, page) {
					console.log(data);
					return {
						results: data
					};
				}
			},
		});
	}	

@stop

