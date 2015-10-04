@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Reports <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Reports
			</li>					
		</ul>
	</div>	

<div class="row">
    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <span class="caption-subject bold uppercase">Vessel</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-condensed table-light">
                        <tbody>
                            <tr>
                                <td>
                                <a href="javascript:;" class="primary-link">Brain</a>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-blue-steel">
                    <span class="caption-subject bold uppercase">Container</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
       
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-thunderbird">
                    <span class="caption-subject bold uppercase">Cargo</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
        
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-yellow-gold">
                    <span class="caption-subject bold uppercase">Miscellaneous</span>
                    <span class="caption-helper">reports</span>
                </div>    
            </div>
            <div class="portlet-body">
        
            </div>
        </div>
    </div>    
</div>




   
@stop

@section('page_level_plugins')


@stop

@section('scripts')


@stop