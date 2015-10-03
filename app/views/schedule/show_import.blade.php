@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		MV. {{ $vesselSchedule->vessel->name}} v.{{ $vesselSchedule->voyage_no_arrival}} <small>import</small>
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
				Import
			</li>					
		</ul>
	</div>	

<!-- Begin: life time stats -->
	<div class="row">
		<div class="col-md-4 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Containers
					</div>
					<div class="actions">
						<a href="{{ route('manifest.schedule.import.containers.create', $vesselSchedule->id) }}" class="btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add Empty Containers
						</a>
					</div>
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
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($vesselSchedule->importContainers as $container)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $container->container_no }}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->m_content }}</td>
										<td>
											@if(count($container->workorders) == 0 && $container->content != 'L')												
												{{ Form::open(['route'=>['manifest.schedule.import.containers.delete', $container->import_vessel_schedule_id], 'id' => 'form_remove_container']) }}
												{{ Form::hidden('container_id', $container->id) }}
						                            <button class='btn btn-sm btn-danger' data-confirm="Remove this container?">
						                                <i class="glyphicon glyphicon-remove"></i>
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
				<!-- END Portlet PORTLET-->
		</div>		

		<div class="col-md-8">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box red">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargoes
					</div>
					<div class="actions">
						<a href="{{ route('manifest.schedule.import.cargoes.create', $vesselSchedule->id) }}" class="btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add 
						</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>B/L #</th>
									<th>Consignor</th>
									<th>Consignee</th>
									<th>Containers</th>
									<th>MT</th>
									<th>M3</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>							
							<tbody>
								<?php $i=1; ?>
								@foreach($vesselSchedule->importCargoes as $cargo)
									<tr class="{{ $cargo->custom_form_no }}">
										<td>{{ $i }}</td>
										<td>{{ link_to_route('manifest.schedule.import.cargoes.show', $cargo->bl_no, [$cargo->import_vessel_schedule_id, $cargo->id]) }}</td>
										<td>{{ $cargo->consignor->name }}</td>
										<td>{{ $cargo->consignee->name }}</td>
										<td>{{ listContainersInString($cargo->m_containers) }}</td>
										<td>{{ $cargo->mt }}</td>
										<td>{{ $cargo->m3 }}</td>
										<td>{{ importCargoStatusTranslator($cargo->status) }}</td>
										<td>{{ link_to_route('manifest.schedule.import.cargoes.edit', 'Edit', [$vesselSchedule->id, $cargo->id]) }}</td>
									</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- END Portlet PORTLET-->
		</div>
	</div>
	<!-- END Portlet PORTLET-->

				
	<div class="clearfix">
	</div>
@stop

@section('page_level_plugins')


@stop

@section('page_level_scripts')


@stop

@section('scripts')
	// TableAdvanced.init();
@stop