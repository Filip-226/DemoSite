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
		@if (count($errors) > 0)
			@foreach ($errors->all() as $error)
			<div id="message"> 
				<div class="alert alert-danger">{{ $error }}</div>
			</div>
			@endforeach
		@endif
				<div class="panel panel-default">

					<div class="panel-heading">
						<h2>{{ Lang::get('auth.login_page') }}</h2>
					</div>
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">

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

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key"></i>
										</span>
										<input type="password" class="form-control" name="password" placeholder="{{ Lang::get('user.password_field') }}">
									</div>
		                        </div>
							</div>

							<div class="form-group mb-n">
								<div class="col-xs-12">
									<div class="checkbox-inline icheck pull-right p-n">
										<label for="">
											<input icheck type="checkbox" name="remember"></input>
											{{ Lang::get('auth.remember_me_field') }}
										</label>
									</div>
								</div>
							</div>
					</div>
					<div class="panel-footer">
						<a href="{{ url('/password/email') }}" class="pull-left">{{ Lang::get('auth.forgot_password_field') }}</a>
						<div class="clearfix">

							<input type="submit" class="btn btn-primary pull-right" value="{{ Lang::get('auth.login_action') }}" />
						</div>
					</div>

					</form>
				</div>
				
				<div class="text-center">
				</div>
			</div>
		</div>
</div>
@endsection