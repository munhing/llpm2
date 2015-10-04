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

<div class="portlet light bordered">
    <div class="portlet-body">
        <div class="caption font-green-sharp">
            <span class="caption-subject uppercase"> Total TEUs</span>
            <span class="caption-helper">weekly stats...</span>
        </div>
        <hr />
        <div class="caption font-blue-hoki">
            <span class="caption-subject uppercase"> Portlet</span>
            <div class="caption-helper">weekly stats...</div>
        </div>          
    </div>
</div>





   
@stop

@section('page_level_plugins')


@stop

@section('scripts')


@stop