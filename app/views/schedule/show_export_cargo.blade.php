@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		{{ $cargo->bl_no }} <small>information</small>
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
				<a href="{{ route('manifest.schedule.export', $schedule->id ) }}"> {{ $schedule->vessel->name}} v.{{ $schedule->voyage_no_departure }}</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				{{ $cargo->bl_no }}
			</li>						
		</ul>
	</div>	

	<div class="row">
		{{ Form::open(['route'=>['manifest.schedule.export.cargoes.issue', $cargo->export_vessel_schedule_id, $cargo->id]]) }}	
		<div class="col-md-8 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo
					</div>

					
					<div class="actions">
						@if($cargo->dl_no == 0 && $cargo->status == 2)
                            
                            <button class='btn btn-sm btn-info' type='button' data-toggle="modal" data-target="#myModal" data-title="Issue DL" data-body="Are you sure you want to Issue DL ?">
                                Issue DL
                            </button>
                            
						@elseif($cargo->dl_no != 0)
							<a href="{{ URL::route('manifest.schedule.export.cargoes.generate', [$schedule->id, $cargo->id]) }}" class="btn btn-default btn-sm" target="_blank">
								<i class="fa fa-edit"></i> View DL 
							</a>
						@endif

						<a href="{{ route('manifest.schedule.export.cargoes.edit', [$schedule->id, $cargo->id]) }}" class="btn btn-default btn-sm">
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
							{{ $cargo->bl_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							D/L #:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->dl_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Consignor:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->consignor->name }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Consignee:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->consignee->name }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							MT:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->mt }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							M3:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->m3 }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Description:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->description }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Markings:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->markings }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Custom Registration #:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->custom_reg_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Custom Form #:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->custom_form_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Port of Discharge:
						</div>
						<div class="col-md-9 value">
							{{ $cargo->country_code }} / {{ $cargo->port_code }}
						</div>						
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
					@if($cargo->status == 1)
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
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($cargo->containers as $container)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $container->container_no }}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->content }}</td>
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
								@foreach($cargoItems as $item)
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
											{{ link_to_route('manifest.schedule.export.cargoes.item.edit', 'Edit', [$schedule->id, $cargo->id, $item->id]) }}
										</td>
									</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>

						{{ Form::open(['route'=>['manifest.schedule.export.cargoes.item.create', $cargo->export_vessel_schedule_id, $cargo->id], 'id'=>'form_add_item']) }}	

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
										<input type="submit" class="btn btn-primary" id="but_add_item">
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

$('#but_add_item').on('click', function(event){
	event.preventDefault();

	$('#form_add_item').submit();
});


@stop

