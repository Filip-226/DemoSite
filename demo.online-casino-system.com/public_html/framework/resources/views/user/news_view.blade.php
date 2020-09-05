@extends('template.app')

@section('header')
	@include('template.header')
@endsection

@section('sidebar')
	@include('template.sidebar')
@endsection

@section('content')
    <ol class="breadcrumb">                       
		<li class=""><a href="{{URL::route('index')}}">{{ Lang::get('general.home_page') }}</a></li>
		<li><a href="{{URL::route('user.dashboard')}}">{{ Lang::get('general.dashboard_page') }}</a></li>
		<li class="active">{{ Lang::get('news.news_label') }}</li>
    </ol>

<div class="container-fluid">
                                
	<div data-widget-group="group1">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ $news->title }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 750px;">
						<div class="scroll-content">
						<?php
							echo $news->content;
						?>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</div> <!-- .container-fluid -->
@endsection

@section('sitescript')
	<!-- Charts -->
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.pie.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.stack.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.orderBars.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.resize.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.tooltip.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.spline.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/sparklines/jquery.sparklines.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/switchery/switchery.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/easypiechart/jquery.easypiechart.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/fullcalendar/moment.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/demo/demo-index.js"></script>
@endsection