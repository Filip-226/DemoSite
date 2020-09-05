@extends('template.app')
@section('sitestyle')

@endsection

@section('header')
<script>

app.directive('ensureEmailUnique', ['$http', function($http) {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ctrl) {
      scope.$watch(attrs.ngModel, function() {
        $http({
          method: 'POST',
          url: '{{ URL::to('/panel/check_') }}' + attrs.ensureEmailUnique,
          data: {'email': ctrl.$viewValue}
        }).success(function(data, status, headers, cfg) {
			if(data == "true") 
				ctrl.$setValidity('unique', true);
			else
				ctrl.$setValidity('unique', false);
        }).error(function(data, status, headers, cfg) {
          ctrl.$setValidity('unique', false);
        });
      });
    }
  }
}]);

app.directive('ensureCurrentPassword', ['$http', function($http) {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ctrl) {
      scope.$watch(attrs.ngModel, function() {
        $http({
          method: 'POST',
          url: '{{ URL::to('/panel/check_') }}' + attrs.ensureCurrentPassword,
          data: {'password': ctrl.$viewValue}
        }).success(function(data, status, headers, cfg) {
			if(data == "true") 
				ctrl.$setValidity('correct', true);
			else
				ctrl.$setValidity('correct', false);
        }).error(function(data, status, headers, cfg) {
          ctrl.$setValidity('correct', false);
        });
      });
    }
  }
}]);

app.directive("passwordVerify", function() {
   return {
      require: "ngModel",
      scope: {
        passwordVerify: '='
      },
      link: function(scope, element, attrs, ctrl) {
        scope.$watch(function() {
            var combined;

            if (scope.passwordVerify || ctrl.$viewValue) {
               combined = scope.passwordVerify + '_' + ctrl.$viewValue; 
            }                    
            return combined;
        }, function(value) {
            if (value) {
                ctrl.$parsers.unshift(function(viewValue) {
                    var origin = scope.passwordVerify;
                    if (origin !== viewValue) {
                        ctrl.$setValidity("passwordVerify", false);
                        return undefined;
                    } else {
                        ctrl.$setValidity("passwordVerify", true);
                        return viewValue;
                    }
                });
            }
        });
     }
   };
});

</script>
@include('template.header')
@endsection

@section('sidebar')
	@include('template.sidebar')
@endsection

@section('content')

		<ol class="breadcrumb">
			<li><a href="{{URL::route('index')}}" target="_self">{{ Lang::get('general.home_page') }}</a></li>
			<li><a href="{{URL::route('user.dashboard')}}">{{ Lang::get('general.dashboard_page') }}</a></li>
			<li class="active">{{ Lang::get('general.member_logindetails_page') }}</li>
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
										<div class="alert alert-success">Successfully updated.</div>
									</div>
								@endif
									<div data-widget-group="group1">

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('general.member_logindetails_page') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="container-fluid">
						<div data-widget-group="group1">
							<form class="form-horizontal" role="form" method="POST" action="{{ url('/panel/login-details') . '?profile=details' }}" id="details_form" name="details_form" data-url="{{ url('/') }}" enctype="multipart/form-data" >

								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								<div class="form-group" style="padding: 10px 0">
									<label class="col-md-2">{{ Lang::get('user.name_field') }}:</label>
									<div class="col-md-10">
										<input type="text" class="required form-control" id="name_txt" name="name_txt" value="{{ Auth::user()->name }}" placeholder="{{ Lang::get('user.name_field') }}" readonly required />
									</div>
								</div>
								
								<div class="form-group" style="padding: 10px 0">
									<label class="col-md-2">{{ Lang::get('user.contact_no_field') }}:</label>
									<div class="col-md-10">
										<input type="text" class="required form-control" id="contact_txt" name="contact_txt" value="{{ Auth::user()->contact_no }}" placeholder="{{ Lang::get('user.contact_no_field') }}" readonly required maxlength="20" />
									</div>
								</div>

								<div class="form-group" style="padding: 10px 0">
									<label class="col-md-2">{{ Lang::get('user.bank_label') }}:</label>
									<div class="col-md-10">
										<select class="required form-control" id="bank_sel" name="bank_sel" disabled required>
											<option value = "">{{ Lang::get('user.bank_field') }}</option>
											@foreach($bank_list as $bank)
							               <option value = "{{ $bank->bank_id }}" {{ ((Auth::user()->bank_id == $bank->bank_id)?'selected':'') }}>{{ $bank->name }}</option>
							               @endforeach
							            </select>
									</div>
								</div>

								<div class="form-group" style="padding: 10px 0">
									<label class="col-md-2">{{ Lang::get('user.bank_account_field') }}:</label>
									<div class="col-md-10">
										<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ Auth::user()->bank_account }}" placeholder="{{ Lang::get('user.bank_account_field') }}" readonly required />
									</div>
								</div>

								<!--div class="form-group" style="padding: 10px 0">
									<label class="col-md-2">{{ Lang::get('user.bank_fullname_field') }}:</label>
									<div class="col-md-10">
										<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ Auth::user()->bank_fullname }}" placeholder="{{ Lang::get('user.bank_fullname_field') }}" required>
									</div>
								</div-->

								<div class="col-md-7">
									<button type="submit" class="btn-success btn" value="submit" id="submit_btn" name="submit_btn">{{ Lang::get('general.submit_action') }}</button>
								</div>

							</form>
						</div>
					</div>

					<br>
								<div class="form-group" style="padding: 10px 0">
									<label class="col-md-2">{{ Lang::get('user.email_address_field') }}:</label>
									<div class="col-md-10">
										{{ Auth::user()->email }} <a href="javascript:void(0);" ng-click="showEmail = ! showEmail">{{ Lang::get('general.edit_action') }}</a>
										<div class="form-group cssFade" ng-show="showEmail" style="padding: 5px 0 30px;">
											<form class="form-horizontal" role="form" method="POST" action="{{ url('/panel/login-details') . '?profile=email' }}" id="email_form" name="email_form" data-url="{{ url('/') }}" enctype="multipart/form-data" novalidate>

												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<div class="col-md-5 remove-padding">
													<input type="email" ng-class="{ 'ng-error' : email_form.email_txt.$invalid && !email_form.email_txt.$pristine }" placeholder="{{ Lang::get('user.email_address_field') }}" id="email_txt" name="email_txt" class="form-control" ensure-email-unique="emailaddress" ng-model="email.emailaddress" required />

													<div class="error" ng-show="email_form.email_txt.$dirty && email_form.email_txt.$invalid">
														<small class="error" ng-show="email_form.email_txt.$error.required">
															{{ Lang::get('user.email_required_msg') }}<br/>
														</small>
														<small class="error" ng-show="email_form.email_txt.$error.email">
															{{ Lang::get('user.email_invalid_msg') }}<br/>
														</small>
														<small class="error" ng-show="email_form.email_txt.$error.unique">
															{{ Lang::get('user.email_duplicate_msg') }}<br/>
														</small>
													</div>
												</div>
												<div class="col-md-7">
													<button type="submit" class="btn-success btn" value="submit" id="submit_btn" name="submit_btn" ng-disabled="email_form.$invalid">{{ Lang::get('general.submit_action') }}</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="form-group" style="padding: 10px 0">
									<label class="col-md-2">{{ Lang::get('user.password_field') }}:</label>
									<div class="col-md-10">
										******** <a href="javascript:void(0);" ng-click="showPassword = ! showPassword">{{ Lang::get('general.edit_action') }}</a>
										<div class="form-group cssFade" ng-show="showPassword" style="padding: 5px 0 30px;">
											<form class="form-horizontal" role="form" method="POST" action="{{ url('/panel/login-details') . '?profile=password' }}" id="password_form" name="password_form" data-url="{{ url('/') }}" enctype="multipart/form-data" novalidate>

												<input type="hidden" name="_token" value="{{ csrf_token() }}">

												<div class="col-md-12">
													<div class="col-md-3" style="padding: 10px 0">
														{{ Lang::get('user.current_password_field') }}
													</div>
													<div class="col-md-9" style="padding: 2px 0">
														<input type="password" ng-class="{ 'ng-error' : password_form.password_txt.$invalid && !password_form.password_txt.$pristine }" placeholder="{{ Lang::get('user.password_field') }}" id="password_txt" name="password_txt" class="form-control" ensure-current-password="password" ng-model="password.Password" required />

														<div class="error" ng-show="password_form.password_txt.$dirty && password_form.password_txt.$invalid">
															<small class="error" ng-show="password_form.password_txt.$error.required">
																{{ Lang::get('user.password_required_msg') }}<br/>
															</small>
															<small class="error" ng-show="password_form.password_txt.$error.correct">
																{{ Lang::get('user.password_invalid_msg') }}<br/>
															</small>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="col-md-3" style="padding: 10px 0">
														{{ Lang::get('user.new_password_field') }}
													</div>
													<div class="col-md-9" style="padding: 2px 0">
														<input type="password" ng-class="{ 'ng-error' : password_form.newpassword_txt.$invalid && !password_form.newpassword_txt.$pristine }" placeholder="{{ Lang::get('user.new_password_field') }}" id="newpassword_txt" name="newpassword_txt" class="form-control" ng-model="password.NewPassword" ng-minlength="8" required />

														<div class="error" ng-show="password_form.newpassword_txt.$dirty && password_form.newpassword_txt.$invalid">
															<small class="error" ng-show="password_form.newpassword_txt.$error.required">
																{{ Lang::get('user.new_password_required_msg') }}<br/>
															</small>
															<small class="error" ng-show="password_form.newpassword_txt.$error.minlength">
																{{ Lang::get('user.new_password_limit_msg') }}<br/>
															</small>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="col-md-3" style="padding: 10px 0">
														{{ Lang::get('user.confirmation_password_field') }}
													</div>
													<div class="col-md-9" style="padding: 2px 0">
														<input type="password" ng-class="{ 'ng-error' : password_form.confirmpassword_txt.$invalid && !password_form.confirmpassword_txt.$pristine }" placeholder="{{ Lang::get('user.confirmation_password_field') }}" id="confirmpassword_txt" name="confirmpassword_txt" class="form-control" ng-model="password.ConfirmPassword" ng-minlength="8" required data-password-verify="password.NewPassword" />

														<div class="error" ng-show="password_form.confirmpassword_txt.$dirty && password_form.confirmpassword_txt.$invalid">
															<small class="error" ng-show="password_form.confirmpassword_txt.$error.minlength">
																{{ Lang::get('user.confirmation_password_limit_msg') }}<br/>
															</small>
															<small class="error" ng-show="password_form.confirmpassword_txt.$error.passwordVerify">
																{{ Lang::get('user.confirmation_password_mismatch_msg') }}<br/>
															</small>

														</div>
													</div>
												</div>
												<div class="col-md-12">
													<button type="submit" class="btn-success btn" value="submit" id="submit_btn" name="submit_btn" ng-disabled="password_form.$invalid">{{ Lang::get('general.submit_action') }}</button>
												</div>
											</form>
										</div>
									</div>
								</div>


				</div>
			</div>
		</div>
	</div>
							
								</div>

							</div> <!-- .container-fluid -->

@endsection

