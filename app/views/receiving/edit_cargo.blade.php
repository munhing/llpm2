@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		{{ $cargo->bl_no }} <small>edit</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('receiving.show', $cargo->receiving_id) }}">Receiving</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				<a href="{{ URL::route('receiving.cargo.show', [$cargo->receiving_id, $cargo->id]) }}">{{ $cargo->bl_no }}</a>
				<i class="fa fa-angle-right"></i>
			</li>				
			<li>
				Edit
			</li>						
		</ul>
	</div>	

	{{ Form::open(['route'=>['receiving.cargo.edit', $cargo->receiving_id, $cargo->id]]) }}
	{{ Form::hidden('cargo_id', $cargo->id) }}
	{{ Form::hidden('receiving_id', $cargo->receiving_id) }}

	<div class="row">
		<div class="col-md-12 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo
					</div>
				</div>
				<div class="portlet-body">

					<div class="form-group">
						{{ Form::label('bl_no', 'B/L No', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
							{{ Form::text('bl_no', $cargo->bl_no, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'B/L No']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('consignor_id', 'Consignor', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-male"></i></span>
							{{ Form::select('consignor_id', $portUsers, $cargo->consignor_id, ['class' => 'form-control select2me']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('consignee_id', 'Consignee', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-male"></i></span>
							{{ Form::select('consignee_id', $portUsers, $cargo->consignee_id, ['class' => 'form-control select2me']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('mt', 'MT', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('mt', $cargo->mt, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'MT']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('m3', 'M3', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('m3', $cargo->m3, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'M3']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('description', 'Description', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::textarea('description', $cargo->description, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Description', 'rows' => '3']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('markings', 'Markings', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::textarea('markings', $cargo->markings, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Markings', 'rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('country_code1', 'Port of Discharge: Country', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-male"></i></span>
							{{ Form::select('country_code', $country, $cargo->country_code, ['class' => 'form-control select2me', 'placeholder' => 'Country']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('port_code', 'Port of Discharge: Port Code (eg. MYLBU, SGSIN, INMAA)', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('port_code', $cargo->port_code, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Port Code']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('custom_reg_no', 'Custom Registration No', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('custom_reg_no', $cargo->custom_reg_no, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Custom Registration No']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('custom_form_no', 'Custom Form No (eg. K1, K2, K8)', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('custom_form_no', $cargo->custom_form_no, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Custom Form No']) }}
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" id="register-submit-btn" class="btn blue">
						Update <i class="m-icon-swapright m-icon-white"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
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

    $('#country_code').select2({
        allowClear: true,
        placeholder: "Select Country"
        
    });

@stop

