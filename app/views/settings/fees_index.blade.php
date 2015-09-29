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
		Fees <small>settings</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Settings - Fees
			</li>					
		</ul>
	</div>	


<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption font-green-sharp">
<i class="icon-speech font-green-sharp"></i>
<span class="caption-subject bold uppercase"> Handling Fee</span>
<span class="caption-helper">setting</span>
</div>
<div class="actions">
<a href="javascript:;" class="btn btn-circle btn-default btn-sm">
<i class="fa fa-pencil"></i> Edit </a>
<a href="javascript:;" class="btn btn-circle btn-default btn-sm">
<i class="fa fa-plus"></i> Add </a>
<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
</a>
</div>
</div>
<div class="portlet-body">
<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><div class="scroller" style="height: 200px; overflow: hidden; width: auto;" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" data-initialized="1">
<h4>Heading Text</h4>
<p>
	 Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
</p>
<p>
	 nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
</p>
</div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 136.986px; background: rgb(161, 178, 189);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; display: none; background: yellow;"></div></div>
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