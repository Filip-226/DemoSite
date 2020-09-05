@extends('template.app')

@section('sitestyle')

@endsection

@section('header')
	@include('template.header')
@endsection

@section('sidebar')
	@include('template.sidebar')
@endsection

@section('content')


                            <ol class="breadcrumb">
								<li><a href="{{URL::route('index')}}">{{ Lang::get('general.home_page') }}</a></li>
								<li><a href="{{URL::route('user.dashboard')}}">{{ Lang::get('general.dashboard_page') }}</a></li>
								<li class="active">{{ Lang::get('inbox.compose') }}</li>
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

									<form class="form-horizontal" role="form" method="POST" action="{{ URL::route('user.inbox_reply', array($msg_id)) }}" id="user_create_form" name="user_create_form" >

									<input type="hidden" name="_token" value="{{ csrf_token() }}">
										


	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('inbox.compose_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-12">{{ Lang::get('inbox.subject_field') }}</label>
						<div class="col-md-12">
						{{ $subject }}
							<input type="hidden" class="required form-control" id="subject_txt" name="subject_txt" value="{{ old('subject_txt') }}" placeholder="{{ Lang::get('inbox.subject_field') }}" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-12">{{ Lang::get('inbox.message_field') }}</label>
						<div class="col-md-12">
							<textarea type="text" class="required form-control" id="message_txt" name="message_txt" value="{{ old('message_txt') }}" required rows="10"> </textarea>
							
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button type="submit" class="btn-success btn" value="submit" id="submit_btn" name="submit_btn">{{ Lang::get('general.submit_action') }}</button>
						</div>
					</div>
				</div>
									
									</form>
					
								</div>

							</div> <!-- .container-fluid -->

@endsection

@section('sitescript')

	<script src="{{ URL::to('/') }}/assets/js/validator.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

@endsection