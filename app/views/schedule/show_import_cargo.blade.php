@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		{{ $importCargo->bl_no }} <small>information</small>
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
				{{ $importCargo->bl_no }}
			</li>						
		</ul>
	</div>	

	<div class="row">
		{{ Form::open(['route'=>['manifest.schedule.import.cargoes.issue', $importCargo->import_vessel_schedule_id, $importCargo->id]]) }}	
		<div class="col-md-8 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo
					</div>

					
					<div class="actions">
						@if($importCargo->dl_no == 0 && $importCargo->status == 2)
                            
                            <button class='btn btn-sm btn-info' type='button' data-toggle="modal" data-target="#myModal" data-title="Issue DL" data-body="Are you sure you want to Issue DL ?">
                                Issue DL
                            </button>
                            
						@elseif($importCargo->dl_no != 0)
							<a href="{{ URL::route('manifest.schedule.import.cargoes.generate', [$schedule->id, $importCargo->id]) }}" class="btn btn-default btn-sm" target="_blank">
								<i class="fa fa-edit"></i> View DL 
							</a>
						@endif

						<a href="{{ route('manifest.schedule.import.cargoes.edit', [$schedule->id, $importCargo->id]) }}" class="btn btn-default btn-sm">
							<i class="fa fa-edit"></i> Edit 
						</a>

					</div>
					

				</div>
				<div class="portlet-body">
					<div class="row static-info">
						<div class="col-md-3 name">
							B/L #:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->bl_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							D/L #:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->dl_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Consignor:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->consignor->name }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Consignee:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->consignee->name }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							MT:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->mt }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							M3:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->m3 }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Description:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->description }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Markings:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->markings }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Custom Registration #:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->custom_reg_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Custom Form #:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->custom_form_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Port of Loading:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->country_code }} / {{ $importCargo->port_code }}
						</div>						
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}

		{{ Form::open(['route'=>['manifest.schedule.import.cargoes.containers.create', $importCargo->import_vessel_schedule_id, $importCargo->id], 'id'=>'form_add_containers']) }}	

		<div id="myModal_autocomplete" class="modal fade" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Add Containers</h4>
					</div>
					<div class="modal-body form">
						
						
						<div class="form-horizontal form-row-seperated">
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon">
										<i class="fa fa-user"></i>
										</span>
										{{ Form::textarea('containers', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Containers', 'rows' => '3', 'id' => 'containers']) }}
									</div>
									<p class="help-block">
										E.g: PCIU1112223-20, TCIU4443332-40
									</p>
								</div>
							</div>
						</div>	
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" id="but_add_container">
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}

		<div class="col-md-4">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box red">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Containers
					</div>
					@if($importCargo->status == 1)
					<div class="actions">
						<a href="#myModal_autocomplete" role="button" class="btn btn-default btn-sm" data-toggle="modal">
							<i class="fa fa-plus"></i> Add
						</a>						
					</div>
					@endif			
				</div>
				<div class="portlet-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Container #</th>
									<th>Size</th>
									<th>E/L</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($importCargo->m_containers as $container)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $container->container_no }}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->m_content }}</td>
										<td>
											@if($container->status == 1 && $container->current_movement == 0)
											{{ Form::open(['route'=>['manifest.schedule.import.cargoes.detach', $importCargo->import_vessel_schedule_id, $importCargo->id]]) }}
											{{ Form::hidden('container_id', $container->id) }}
					                            <button class='btn btn-sm btn-danger' type='button' data-toggle="modal" data-target="#myModal" data-title="Unlink Cargo" data-body="Unlink cargo from this container?">
					                                <i class="fa fa-unlink"></i>
					                            </button>											
											{{ Form::close() }}
											@endif
										</td>
									</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="row">
		
		<div class="col-md-8 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo Items
					</div>
					<div class="actions">
						<a class="btn btn-default btn-sm" href="#myModal_cargoitem" data-toggle="modal">
							<i class="fa fa-plus"></i> Add 
						</a>						
					</div>					
				</div>
				<div class="portlet-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Code</th>
									<th>Description</th>
									<th>Qty</th>
									<th>Unit</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($importCargoItems as $item)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $item->custom_tariff_code }}</td>
										<td>{{ $item->description }}</td>
										<td>{{ $item->quantity }}</td>
										<td>
											@if(isset($item->custom_tariff->uoq))
												{{ $item->custom_tariff->uoq }}
											@endif
										</td>
										<td>
											{{ link_to_route('manifest.schedule.import.cargoes.item.edit', 'Edit', [$schedule->id, $importCargo->id, $item->id]) }}
										</td>
									</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>

						{{ Form::open(['route'=>['manifest.schedule.import.cargoes.item.create', $importCargo->import_vessel_schedule_id, $importCargo->id], 'id'=>'form_add_containers']) }}	

						<div id="myModal_cargoitem" class="modal fade" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Add Cargo Item</h4>
									</div>
									<div class="modal-body">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-md-4">Tariff Code</label>
												<div class="col-md-8">
													{{ Form::text('custom_tariff_code') }}
												</div>
											</div>										
											<div class="form-group">
												<label class="control-label col-md-4">Description</label>
												<div class="col-md-8">
													{{ Form::text('description') }}
												</div>
											</div>
											<div class="form-group last">
												<label class="control-label col-md-4">Quantity</label>
												<div class="col-md-8">
													{{ Form::text('quantity') }}
												</div>
											</div>											
										</div>	
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<input type="submit" class="btn btn-primary" id="but_add_container">
									</div>
								</div>
							</div>
						</div>

						{{ Form::close() }}

					</div>
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
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js') }}"></script>
@stop

@section('page_level_scripts')
<script type="text/javascript" src="{{ URL::asset('assets/app/js/app.js') }}"></script>
@stop

@section('scripts')
ComponentsPickers.init();
ComponentsDropdowns.init();

$('#but_add_container').on('click', function(event){
	event.preventDefault();

	console.log($.trim($('#containers').val()));

	if(! $.trim($('#containers').val()) == "") {
		$('#form_add_containers').submit();
	}
});


@stop

