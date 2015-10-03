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
		Receiving<small>receiving</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('receiving') }}">Receiving</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				Receiving
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
								@foreach($containers as $container)
									<?php $woRI = getWorkOrderRI($container->workorders); ?>
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $container->container_no }}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->content }}</td>
										<td>
											@if(count($container->workorders) == 0 && $container->content != 'L')
												{{ Form::open(['route'=>['receiving.container.delete', $container->receiving_id]]) }}
												{{ Form::hidden('container_id', $container->id) }}
						                            <button class='btn btn-sm btn-danger' type='button' data-toggle="modal" data-target="#myModal" data-title="Remove Container" data-body="Remove this container?">
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
						<i class="fa fa-info"></i>Export Cargoes
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
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
								@foreach($receiving->cargoes as $cargo)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ link_to_route('receiving.cargo.show', $cargo->bl_no, [$cargo->receiving_id, $cargo->id]) }}</td>
										<td>{{ $cargo->consignor->name }}</td>
										<td>{{ $cargo->consignee->name }}</td>
										<td>{{ listContainersInString($cargo->containers) }}</td>
										<td>{{ $cargo->mt }}</td>
										<td>{{ $cargo->m3 }}</td>
										<td>{{ importCargoStatusTranslator($cargo->status) }}</td>
										<td>{{ link_to_route('receiving.cargo.edit', 'Edit', [$cargo->receiving_id, $cargo->id]) }}</td>										
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
@stop