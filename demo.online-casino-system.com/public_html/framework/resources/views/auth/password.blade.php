@extends('template.app')

@section('header')
	@include('template.header_auth')
@endsection

@section('content')
<div class="container" id="login-form" >
	<a href="{{ URL::to('/auth/login') }}" class="login-logo">
		<img src="{{ URL::to('/') }}/images/logo/logo.png" alt="{{ Lang::get('general.app_name') }}" />
	</a>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
		@if (session('status'))
			<div id="message"> 
				<div class="alert alert-success">{{ session('status') }}</div>
			</div>
		@endif
			
		@if (count($errors) > 0)
			@foreach ($errors->all() as $error)
			<div id="message"> 
				<div class="alert alert-danger">{{ $error }}</div>
			</div>
			@endforeach
		@endif
				<div class="panel panel-default">

					<div class="panel-heading">
						<h2>{{ Lang::get('auth.reset_password_page') }}</h2>
					</div>
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="panel-body">
						
							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ Lang::get('user.email_address_field') }}" required>
									</div>
		                        </div>
							</div>
					</div>
					<div class="panel-footer">
						<div class="clearfix">

							<input type="submit" class="btn btn-primary pull-right" value="{{ Lang::get('auth.send_password_reset_action') }}" />
						</div>
					</div>
					
					</form>
				</div>
				
			</div>
		</div>
</div>
@endsection