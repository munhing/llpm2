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
            <i class="fa fa-dollar font-green-sharp"></i>
            <span class="caption-subject bold uppercase"> Handling Fee</span>
            <span class="caption-helper">setting</span>
        </div>
        <div class="actions">
            <button class='btn btn-default btn-sm' type='button' data-toggle="modal" data-target="#myModal_handlingFee" data-title="Update Cargo Item" data-action="update">
                <i class="fa fa-plus"></i> Add 
            </button>        
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>20E</th>
                <th>20L</th>
                <th>40E</th>    
                <th>40L</th>    
                <th>Effective Date</th>   
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($handlingFees as $handlingFee)
                <?php $fee = json_decode($handlingFee->fee, true); ?>
                <tr>
                    <td>{{ $i }}</td> 
                    <td align="right">{{ number_format($fee['20E'], 2) }}</td>
                    <td align="right">{{ number_format($fee['20L'], 2) }}</td>
                    <td align="right">{{ number_format($fee['40E'], 2) }}</td>                             
                    <td align="right">{{ number_format($fee['40L'], 2) }}</td>
                    <td>{{ $handlingFee->effective_date->format('Y-m-d') }}</td>
                    <td>
                        <a href="javascript:;" class="btn btn-default btn-sm">
                            <i class="fa fa-pencil"></i> Edit 
                        </a>                         
                    </td>                                       
                </tr>
                <?php $i++; ?>
            @endforeach
        </tbody>
        </table>
        </div>        
    </div>
</div>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green-sharp">
            <i class="fa fa-dollar font-green-sharp"></i>
            <span class="caption-subject bold uppercase"> Storage Fee</span>
            <span class="caption-helper">setting</span>
        </div>
        <div class="actions">
            <a href="javascript:;" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add 
            </a>         
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>20</th>
                <th>40</th>    
                <th>Effective Date</th>   
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($storageFees as $storageFee)
                <?php $fee = json_decode($storageFee->fee, true); ?>
                <tr>
                    <td>{{ $i }}</td> 
                    <td align="right">{{ number_format($fee['20'], 2) }}</td>
                    <td align="right">{{ number_format($fee['40'], 2) }}</td>                             
                    <td>{{ $storageFee->effective_date->format('Y-m-d') }}</td>
                    <td>
                        <a href="javascript:;" class="btn btn-default btn-sm">
                            <i class="fa fa-pencil"></i> Edit 
                        </a>                         
                    </td>                                       
                </tr>
                <?php $i++; ?>
            @endforeach
        </tbody>
        </table>
        </div> 
    </div>
</div>

    <div class="row">
    {{ Form::open() }}   

    <div class="modal fade" id="myModal_handlingFee" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="myModalLabel">Add Handling Fee</h4>
                    {{ Form::hidden('form_action', '', ['id'=>'form_action']) }}
                    {{ Form::hidden('handling_fee_id', '', ['id'=>'handling_fee_id']) }}
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">20" Empty</label>
                                    <div class="col-md-6">
                                        {{ Form::text('custom_tariff_code','', ['id'=>'custom_tariff_code', 'class'=>'form-control']) }}
                                        <span id="err-tariff" class="badge badge-danger"></span>
                                        <span id="suc-tariff" class="badge badge-success"></span>
                                        <span id="inf-tariff" class="badge badge-info"></span>
                                    </div>

                                    <label class="control-label col-md-2">Unit of Quantity</label>
                                    <div class="col-md-2">
                                        {{ Form::text('uoq','', ['id'=>'uoq','class'=>'form-control']) }}
                                    </div>                                   
                                </div>  
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Description</label>
                                    <div class="col-md-10">
                                        {{ Form::textarea('description','', ['id'=>'description','class'=>'form-control', 'rows'=>'3']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group last">
                                    <label class="control-label col-md-2">Quantity</label>
                                    <div class="col-md-4">
                                        {{ Form::text('quantity','', ['id'=>'quantity','class'=>'form-control']) }}
                                        <span id="err-quantity" class="badge badge-danger"></span>
                                        <span id="suc-quantity" class="badge badge-success"></span>
                                        <span id="inf-quantity" class="badge badge-info"></span>                                        
                                    </div>
                                </div>
                            </div>                                          
                        </div>  
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" id="but_cargo_item" data-confirm="Are you sure?">
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
      
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