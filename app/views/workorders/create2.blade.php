@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		Issue Work Order <small>form</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('workorders') }}">Work Order</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Issue Work Order
			</li>					
		</ul>
	</div>	

	<div class="row">
		<div class="col-md-12">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						Form
					</div>
				</div>
				<div class="portlet-body">
					{{ Form::open(['id' => 'form_workorder']) }}

        				<div class="form-horizontal">
                            <div class="row"><div class="col-md-12">
            					<div class="form-group">
            						<label class="control-label col-md-2">Type</label>
            						<div class="col-md-5">
            							{{ Form::select('type', ['' => '', 'HI' => 'Haulage Import', 'HE' => 'Haulage Export', 'RI-1' => 'Remove In (CY1)', 'RI-3' => 'Remove In (CY3)', 'RO-1' => 'Remove Out (CY1)', 'RO-3' => 'Remove Out (CY3)', 'TF-3-1' => 'Transfer to CY1', 'TF-1-3' => 'Transfer to CY3', 'US' => 'Unstuffing', 'ST' => 'Stuffing'], null, ['class' => 'form-control', 'placeholder' => 'Select Work Order Type', 'id'=>'type']) }}
                                        <span id="err-tariff" class="badge badge-danger"></span>
                                        <span id="suc-tariff" class="badge badge-success"></span>
                                        <span id="inf-tariff" class="badge badge-info"></span>
            						</div>                                  
            					</div>
                            </div></div>
                            <div class="row"><div class="col-md-12">
            					<div class="form-group">
            						<label class="control-label col-md-2">Handler</label>
            						<div class="col-md-8">
            							{{ Form::hidden('handler_id','', ['id'=>'handler_id','class'=>'form-control', 'data-placeholder'=>"Choose a handler..."]) }}
            						</div>
            					</div>
                            </div></div>                          
                            <div class="row"><div class="col-md-12">
            					<div class="form-group">
            						<label class="control-label col-md-2">Carrier</label>
            						<div class="col-md-8">
										<div id="carrier">
											Please select the Work Order type first...
										</div>
            						</div>
            					</div>
                            </div></div>
                            <div class="row" id="container_div"><div class="col-md-12">
            					<div class="form-group">
            						<label class="control-label col-md-2">Containers</label>
            						<div class="col-md-8">
            							{{ Form::select('containers[]', [], null, ['class' => 'form-control select2me', 'placeholder' => 'Select Containers', 'multiple', 'id'=>'ctn', 'spinner']) }}
                                        <span id="err-quantity" class="badge badge-danger"></span>
                                        <span id="suc-quantity" class="badge badge-success"></span>
                                        <span id="inf-quantity" class="badge badge-info"></span>            							
            						</div>
            					</div>
                            </div></div>
                            <div class="row" id="container_div_st"><div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-2">Containers <span class="required">
									* </span>
									</label>
									<div class="col-md-8">
										{{ Form::select('ctn_st', [], null, ['class' => 'form-control select2me', 'placeholder' => 'Select Containers', 'id'=>'ctn_st']) }}
									</div>
									<div class="col-md-2">
										{{ Form::button('Add', ['class' => 'btn green default', 'id' => 'button-add']) }}
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-1 col-md-8">
										<div class="portlet box blue">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-gift"></i> Select Cargo for Stuffing
												</div>
											</div>
											<div class="portlet-body" id="container-data">
											
											</div>
										</div>
									</div>
								</div>								
							</div></div>
                            <div class="row"><div class="col-md-offset-2 col-md-10">
            					<div class="form-action">
				    				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				    				<input type="submit" class="btn btn-primary" id="but_cargo_item" data-confirm="Are you sure?">
            					</div>
                            </div></div>
        				</div>	

					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>



@stop

@section('page_level_plugins')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

@stop

@section('page_level_scripts')
@stop

@section('scripts')

	function toggleContainerDiv(movement)
	{
		if(movement == 'ST') {
			$('#container_div').hide();
			$('#container_div_st').show();
		} else {
			$('#container_div').show();
			$('#container_div_st').hide();		
		}
	}

	$('#handler_id').select2({
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

	$('#type').on('change', function(){
		console.log($(this).val());

		$('#ctn').select2('data', ''); // clear selected containers
		$('#ctn').empty(); // empty all options

		// alert($('#type').val());
		var movement = $(this).val();
		var movement_array = movement.split('-');

		toggleContainerDiv(movement_array[0]);

		// alert(movement_array[1]);
		// throw 'Stop Code';

		if(movement_array[0] == 'HI' || movement_array[0] == 'HE') {

			// remove and create input field with id=carrier_id

			$('#carrier').empty();
			$('#carrier').append("<select id='carrier_id' name='carrier_id' class='form-control select2me' data-placeholder='Choose a Carrier...'>");

        	$.ajax({
	            url: '{{ route('workorders.carrier_list') }}',
	            dataType: 'json',
	            type: 'GET',
	            data: {type : movement_array[0] },
	            success: function(data) {

	            	$('#carrier_id').select2('data', null);

	                $('#carrier_id').append($('<option></option>').attr('value', '').text(''));

	                for (row in data) {
	                    $('#carrier_id').append($('<option></option>').attr('value', data[row].id).text(data[row].name));
	                }
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	                alert(errorThrown);
	            }
	        });

		} else if(movement_array[0] == 'ST') {
			console.log('Stuffing');
		} else {

			$('#carrier').empty();
			$('#carrier').append("<input type='hidden' id='carrier_id' name='carrier_id' class='form-control' data-placeholder='Choose a Carrier...' />");

			$('#carrier_id').select2({
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
	});

    $('#carrier').on('change', '#carrier_id', function() {

		// alert($('#type').val());
		// throw 'Stop Here';

		$.ajax({
			url: '{{ route('workorders.container_list') }}',
			dataType: 'json',
			type: 'GET',
			data: {carrier_id : $('#carrier_id').val(), type : $('#type').val() },
			success: function(data) {

				console.log(data);

				$('#ctn').select2('data', null)
				$('#ctn').empty(); // clear the current elements in select box

				for (row in data) {
					$('#ctn').append($('<option></option>').attr('value', data[row].id).text(data[row].container_no));
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});

    });	

@stop

