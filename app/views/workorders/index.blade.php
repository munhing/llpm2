@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Work Order <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Work Order
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-anchor"></i>Work Order
		</div>
		<div class="tools">
			{{ Form::open(['class' => 'form-inline']) }}
			<div class="form-group">
			{{ Form::text('view_date', Session::get('workorder.date'), ['class' => 'form-control form-control-inline input-sm month-picker', 'placeholder' => 'Month']) }}
			</div>
			<div class="form-group">
				<button type="submit" id="register-submit-btn" class="btn btn-sm blue">
				View <i class="m-icon-swapright m-icon-white"></i>
				</button>
			</div>
			{{ Form::close() }}
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Work Order #</th>
				<th>Movement</th>
				<th>Date</th>
				<th>Carrier</th>	
				<th>Storage</th>	
				<th>Handling</th>	
				<th>Action</th>	
			</tr>
		</thead>
		<tbody>
			@foreach($workorders as $workorder)
				<tr>
					<td>{{ link_to_route('workorders.show', $workorder->id, $workorder->id) }}</td>	
					<td>{{ $workorder->movement }}</td>
					<td>{{ $workorder->date->format('d/m/Y') }}</td>
					<td>{{ $workorder->getCarrier() }}</td>								
					<td align="right">{{ number_format($workorder->containers->sum('storage_charges'), 2) }}</td>
					<td align="right">{{ number_format($workorder->containers->sum('handling_charges'), 2) }}</td>
					<td></td>										
				</tr>
			@endforeach
		</tbody>
		</table>
		</div>
	</div>
</div>


@stop

@section('page_level_plugins')

@{{<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>}}
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
@{{ <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script> }}
@{{ <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script> }}
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>


@stop

@section('page_level_scripts')

<script src="{{ URL::asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>

@stop

@section('scripts')
	//TableAdvanced.init();
	ComponentsPickers.init();
@stop