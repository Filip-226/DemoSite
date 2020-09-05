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
								<li><a href="{{URL::route('panel.admin.user_manage')}}">{{ Lang::get('general.user_manage_page') }}</a></li>
								<li class="active">{{ Lang::get('general.user_edit_page') }}</li>
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

									<form class="form-horizontal" role="form" method="POST" action="{{ url('/panel/admin/user/edit/' . $user->user_id) }}" id="user_edit_form" name="user_edit_form" data-url="{{ url('/') }}" enctype="multipart/form-data" data-toggle="validator" role="form">

									<input type="hidden" name="_token" value="{{ csrf_token() }}">

										@include('admin.user_form', array('is_new'=>false) )
									
									</form>
					
								</div>

							</div> <!-- .container-fluid -->

@endsection

@section('sitescript')

	<script src="{{ URL::to('/') }}/assets/js/validator.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	
	<script>
	function appendProduct() {
		$('#user_products').append('<div class="form-group"><div class="col-md-5">' +
								'<select name="casino_id[]" id="casino_id" class="required form-control" required >' +
								@foreach($casino_list as $casino)
									'<option value="{{ $casino->casino_id }}">{{ $casino->name }}</option>' +
								@endforeach
								'</select>' +
								'</div>' +
								'<div class="col-md-6">' +
								'<input type="text" name="casino_no[]" id="casino_no[]" value="" class="required form-control" required />' +
								'<input type="hidden" name="casino_row[]" id="casino_row[]" value="" class="form-control" />' +
								'</div>' +
								'<div class="col-md-1">' +
									'<a href="javascript: void(0);" onclick="$(this).parent().parent().remove(\'.form-group\');"><i class="fa fa-minus-circle"></i></a>' +
								'</div></div>');
	}
	</script>

@endsection