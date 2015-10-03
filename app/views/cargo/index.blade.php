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
		Cargoes <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Cargoes
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			Cargo
		</div>
		<div class="tools">

		</div>
	</div>
	<div class="portlet-body">
		<div class="table-responsive">

			{{ Form::open() }}

				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th></th>
							<th>BL #</th>
							<th>MT</th>
							<th>M3</th>
							<th>Status</th>
							<th>Container(s)</th>
						</tr>
					</thead>
					<tbody>
						@foreach($cargoes as $cargo)
						<tr>
							<td>

							</td>
							<td>
								{{ $cargo->bl_no }}							
							</td>
							<td>{{ $cargo->mt }}</td>
							<td>{{ $cargo->m3 }}</td>
							<td>{{ importCargoStatusTranslator($cargo->status) }}</td>
							<td>
								@foreach($cargo->containers as $ctn)
									{{ $ctn->container_no }}
								@endforeach
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

                <button class='btn btn-sm blue' type='button' data-toggle="modal" data-target="#myModal" data-title="Cargo Confirmation" data-body="Confirm this cargo?">
                    Confirm <i class="m-icon-swapright m-icon-white"></i>
                </button>											


			{{ Form::close() }}

		</div>
	</div>
</div>


@stop

@section('page_level_plugins')


@stop

@section('page_level_scripts')


@stop

@section('scripts')

@stop