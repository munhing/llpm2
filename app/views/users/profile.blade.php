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
		{{ Auth::user()->name }} <small>profile</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Profile
			</li>					
		</ul>
	</div>	


<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green-sharp">
            <i class="fa fa-user font-green-sharp"></i>
            <span class="caption-subject bold uppercase"> My Profile</span>
            <span class="caption-helper">info</span>
        </div>
        <div class="actions">
            <button class='btn btn-default btn-sm' type='button' data-toggle="modal" data-target="#myModal_handlingFee" data-title="Add Handling Fee" data-fee-type="handling">
                <i class="fa fa-key"></i> Change Password 
            </button>   
            <button class='btn btn-default btn-sm' type='button' data-toggle="modal" data-target="#myModal_handlingFee" data-title="Add Handling Fee" data-fee-type="handling">
                <i class="fa fa-pencil"></i> Edit 
            </button>                  
        </div>
    </div>
    <div class="portlet-body">
        <div class="row static-info">
            <div class="col-md-5 name">
                 Name:
            </div>
            <div class="col-md-7 value">
                 {{ Auth::user()->name }}
            </div>
        </div>
        <div class="row static-info">
            <div class="col-md-5 name">
                 Email:
            </div>
            <div class="col-md-7 value">
                 {{ Auth::user()->email }}
            </div>
        </div>
        <div class="row static-info">
            <div class="col-md-5 name">
                 Role:
            </div>
            <div class="col-md-7 value">
                 {{ Auth::user()->roles->first()->role }}
            </div>
        </div>
    </div>    
    </div>
      
@stop

@section('page_level_plugins')


@stop

@section('scripts')


@stop