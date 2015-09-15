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
		Containers Confirmation <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Confirmation
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-anchor"></i>Containers Confirmation
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
							<th>Container #</th>
							<th>Size</th>
							<th>Work Order #</th>
							<th>Movement</th>
							<th>CP1</th>
							<th>CP2</th>
							<th>CP3</th>
							<th>CP4</th>
							<th>Carrier</th>
							<th>Lifter</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1;?>
						@foreach($containers as $container)
                		<?php $movement =  $container->workorders->last()->movement; ?>
                		<?php $id = $container->id . ',' . $container->content . ',' . $container->current_movement . ',' . $movement; ?>

						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $container->container_no }}</td>
							<td>{{ $container->size . $container->content }}</td>
							<td>{{ $container->current_movement }}</td>
							<td>{{ $movement }}</td>
                    		<td class="{{ $check_points[$movement]->cp1 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp1 }}</td>
                    		<td class="{{ $check_points[$movement]->cp2 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp2 }}</td>
                    		<td class="{{ $check_points[$movement]->cp3 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp3 }}</td>
                    		<td class="{{ $check_points[$movement]->cp4 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp4 }}</td>
		                    <td>{{ $container->workorders->last()->pivot->vehicle }}</td>
		                    <td>{{ $container->workorders->last()->pivot->lifter }}</td>
							<td>
								<button type="submit" id="register-submit-btn" class="btn blue">
								Confirm <i class="m-icon-swapright m-icon-white"></i>
								</button>								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			{{ Form::close() }}

		</div>
	</div>
</div>

<div class="modal fade edit-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
          <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Edit</h4>
                </div>
          <div class="modal-body">
                <form class="form-edit">
                      <div class="form-group">
                             {{ Form::label('carrier','Carrier') }}
                             {{ Form::text('carrier','', ['id'=>'carrier', 'class'=>'form-control']) }}
                      </div>
                      <div class="form-group">
                             {{ Form::label('lifter','Lifter') }}
                             {{ Form::text('lifter','', ['id'=>'lifter', 'class'=>'form-control']) }}
                      </div>                          
                      <button class="btn btn-lg btn-success btn-block edit-btn">
                            Save
                      </button>                  
                </form>
          </div>

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