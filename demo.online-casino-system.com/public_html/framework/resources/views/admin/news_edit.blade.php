@extends('template.app')

@section('sitestyle')

@endsection

@section('header')
	@include('template.header')
	<script src="{{ URL::to('/') }}/js/ckeditor/ckeditor.js"></script>
@endsection

@section('sidebar')
	@include('template.sidebar')
@endsection

@section('content')

                            <ol class="breadcrumb">
								<li><a href="{{URL::route('index')}}">{{ Lang::get('general.home_page') }}</a></li>
								<li><a href="{{URL::route('user.dashboard')}}">{{ Lang::get('general.dashboard_page') }}</a></li>
								<li><a href="{{URL::route('panel.admin.news_manage')}}">{{ Lang::get('general.news_manage_page') }}</a></li>
								<li class="active">{{ Lang::get('general.news_edit_page') }}</li>
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

									<form class="form-horizontal" role="form" method="POST" action="{{ url('/panel/admin/news/edit/' . $news->news_id) }}" id="news_edit_form" name="news_edit_form" data-url="{{ url('/') }}" enctype="multipart/form-data" >

									<input type="hidden" name="_token" value="{{ csrf_token() }}">

										@include('admin.news_form', array('is_new'=>false) )
									
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