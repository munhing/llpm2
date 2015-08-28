<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.1
Version: 3.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>LLPM | Work Order</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<link href="{{ URL::asset('assets/admin/pages/css/invoice.css') }}" rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset('assets/global/css/components.css') }}" rel="stylesheet" type="text/css" id="style_components"/>
<link href="{{ URL::asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>

<link rel="shortcut icon" href="favicon.ico"/>

<style>

body {
	margin:0;
	padding:0;
	height:100%;
	background-color: silver;
}

#wrapper {
	min-height:100%;
	position:relative;
}

#header {
	background:#ededed;
	padding:10px;
}

#content {
	padding-bottom:100px; /* Height of the footer element */
}

#footer {
	background:#ffab62;
	width:100%;
	height:100px;
	position:absolute;
	bottom:0;
	left:0;
}
.page-content-wrapper .page-content {
  margin-left: 0px;
}

.fineprint {
	font-size: xx-small;
	text-align: center;
}
</style>

</head>

<body>

	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN PAGE CONTENT-->
				<div class="invoice" id="wrapper">

					<div id="header">
						<div class="row invoice-logo">
							<div class="col-xs-6">
								<p style="text-align: left">Work Order
									<span class="muted">
										Remove In	
									</span>
								</p>
							</div>
							<div class="col-xs-6">
								<p>
									No: {{ $workOrder->workorder_no }}
									<span class="muted">
										{{ $workOrder->date->toFormattedDateString() }}	
									</span>
								</p>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-xs-6" style="text-align: center">
								<p>Handler: {{ $workOrder->handler_id }}</p>
							</div>
							<div class="col-xs-6" style="text-align: center">
								<p>Carrier: {{ $workOrder->carrier_id }}</p>
							</div>
						</div>
					</div>

					<!-- Table -->
					<div id="content">
						<div class="row">
							<div class="col-xs-12">
								<table class="table table-striped table-hover">
								<thead>
								<tr>
									<th>
										 #
									</th>
									<th>
										 Container #
									</th>
									<th class="hidden-480">
										 Size
									</th>
									<th class="hidden-480">
										 Status
									</th>
									<th class="hidden-480">
										 Remarks
									</th>
								</tr>
								</thead>
								<tbody>
								{{ $no = 1 }}
								@foreach($workOrder->containers as $container)
								<tr>
									<td>
										 {{ $no }}
									</td>
									<td>
										 {{ $container->container_no }}
									</td>
									<td class="hidden-480">
										 {{ $container->size }}
									</td>
									<td class="hidden-480">
										 {{ $container->content }}
									</td>
									<td class="hidden-480">
										 
									</td>
								</tr>
								{{ $no++ }}
								@endforeach
								</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- Signature -->
					<div id="footer">
						<div class="row">
							<div class="col-xs-4" style="text-align: center">
								<p>CY Supervisor</p>
							</div>
							<div class="col-xs-4" style="text-align: center">
								<p>Owner/Agent</p>
							</div>
							<div class="col-xs-4" style="text-align: center">
								<p>Handler</p>
							</div>						
						</div>

						<!-- Fineprints -->
						<div class="row fineprint">
							<p>
								Received the above in good order and condition.
							</p>
						</div>

						<div class="row fineprint">
							<p>
								<b>NOTE: </b>All operations to handling or storage of import and export of goods/containers within the storage area shall
								be under the directive and supervision of LABUAN LIBERTY PORT MANAGEMENT SDN.BHD. (LLPM) <br>
								No labour and equipments be brought into the storage area without prior authorization from LLPM.
							</p>
						</div>
					</div>

				</div>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
		<!-- END CONTENT -->
	</div>

</body>
<!-- END BODY -->
</html>