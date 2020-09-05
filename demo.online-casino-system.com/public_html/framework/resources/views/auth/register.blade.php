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
						<h2>{{ Lang::get('auth.register_page') }}</h2>
					</div>
					<form class="form-horizontal" role="form" id="registrationForm" method="POST" action="{{ url('/auth/register') }}">

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="panel-body">
						
							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="fa fa-tag"></i>
										</span>
										<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ Lang::get('user.name_field') }}" required>
									</div>
		                        </div>
							</div>

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="fa fa-envelope"></i>
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
										<input type="password" class="form-control" name="password" placeholder="{{ Lang::get('user.password_field') }}" minlength="8" required />
									</div>
		                        </div>
							</div>

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key"></i>
										</span>
										<input type="password" class="form-control" name="password_confirmation" placeholder="{{ Lang::get('user.confirmation_password_field') }}" minlength="8" required />
									</div>
		                        </div>
							</div>
							
							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-phone"></i>
										</span>
										<input type="text" class="form-control" name="contact_no" value="{{ old('contact_no') }}" placeholder="{{ Lang::get('user.contact_no_field') }}" required maxlength="20">
									</div>
		                        </div>
							</div>
							
							<div class="input-group mb-md" style="display:none;">
		                        <div class="col-xs-12">
		                        	<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<input type="text" class="form-control" name="referer_name" id="referer_name" placeholder="{{ Lang::get('user.referer_name_field') }}">
										<input type="hidden" class="form-control" name="referer_check" id="referer_check" />
									</div>
		                        </div>
							</div>
							
							<div class="form-group mb-md">
		                        <div class="col-xs-12 text-center">
										<input type="checkbox" class="" name="agree" required />
										I have read and agree to the <a href="">privacy policy</a>
		                        </div>
							</div>
							<!--div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="fa fa-bank"></i>
										</span>
										<select class="required form-control" id="bank_id" name="bank_id" required>
											<option value = "">{{ Lang::get('user.bank_field') }}</option>
											@foreach($bank_list as $bank)
							               <option value = "{{ $bank->bank_id }}">{{ $bank->name }}</option>
							               @endforeach
							            </select>
									</div>
		                        </div>
							</div>

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="fa fa-briefcase"></i>
										</span>
										<input type="number" class="form-control" name="bank_account" value="{{ old('bank_account') }}" placeholder="{{ Lang::get('user.bank_account_field') }}" required>
									</div>
		                        </div>
							</div>

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="fa fa-tag"></i>
										</span>
										<input type="text" class="form-control" name="bank_fullname" value="{{ old('bank_fullname') }}" placeholder="{{ Lang::get('user.bank_fullname_field') }}" required>
									</div>
		                        </div>
							</div-->
					</div>
					<div class="panel-footer">
						<div class="clearfix">

							<input type="submit" class="btn btn-primary pull-right" value="{{ Lang::get('auth.register_action') }}" />
						</div>
					</div>
					
					</form>
				</div>
				
			</div>
		</div>
</div>

@endsection