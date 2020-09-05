@extends('template.app')

@section('sitestyle')

@endsection

@section('header')
		@include('template.header')
		<link rel="stylesheet" href="{{ URL::to('/') }}/css/smoothzoom/smoothzoom.css"/>
@endsection

@section('sidebar')
	@include('template.sidebar')
@endsection

@section('content')


                            <ol class="breadcrumb">
								<li><a href="{{URL::route('index')}}">{{ Lang::get('general.home_page') }}</a></li>
								<li><a href="{{URL::route('user.dashboard')}}">{{ Lang::get('general.dashboard_page') }}</a></li>
								<li><a href="{{URL::route('user.history_manage')}}">{{ Lang::get('general.transaction_history_page') }}</a></li>
								<li class="active">{{ Lang::get('general.transaction_view_verifiedtransaction_page') }}</li>
                            </ol>

							<div class="container-fluid">
								@if (Session::has('error_message'))
									<div id="message"> 
										<div class="alert alert-danger">{{ Session::get('error_message') }}</div>
									</div>
								@elseif(Session::has('message'))
									<div id="message"> 
										<div class="alert alert-success">{{ Session::get('message') }}</div>
									</div>
								@elseif(isset($_GET['success']) && $_GET['success'] == 1)
									<div id="message"> 
										<div class="alert alert-success">{{ Lang::get('general.successfully_update_common_msg') }}</div>
									</div>
								@endif
								<div data-widget-group="group1">

									<form class="form-horizontal" role="form" method="POST" action="{{ url('/panel/history/view/' . $history->history_id) }}" id="history_details_form" name="history_details_form" data-url="{{ url('/') }}" enctype="multipart/form-data" >

									<input type="hidden" name="_token" value="{{ csrf_token() }}">
										
										@include('user.history_form')
									
									</form>
					
								</div>

							</div> <!-- .container-fluid -->

@endsection

@section('sitescript')

	<script src="{{ URL::to('/') }}/assets/js/validator.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script src="{{ URL::to('/') }}/js/smoothzoom/js/easing.js"></script>
	<script src="{{ URL::to('/') }}/js/smoothzoom/js/smoothzoom.min.js"></script>

	<script type="text/javascript">
        $(window).load( function() {
            $('#uploaded_image_img').smoothZoom({
            	// Options go here
            });
        });
    </script>
    <script>
    	$('#uploaded_image_img').hover(function() {
                $('#uploaded_image_img').not(this).css('opacity','.6');
            }, function() {
		    $('#uploaded_image_img').not(this).css('opacity','1');
		});
    </script>

@endsection