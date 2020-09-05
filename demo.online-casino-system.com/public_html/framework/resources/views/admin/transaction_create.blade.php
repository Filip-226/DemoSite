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
								<li class="active">{{ Lang::get('general.transaction_add_page') }}</li>
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

									<form class="form-horizontal" role="form" method="POST" action="{{ url('/panel/admin/transaction/add') }}" id="transaction_create_form" name="transaction_create_form" data-url="{{ url('/') }}" enctype="multipart/form-data" >

									<input type="hidden" name="_token" value="{{ csrf_token() }}">
										


	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('transaction.transaction_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					@if(\Input::get('action') != "" && (\Input::get('action') == 'topup' || \Input::get('action') == 'withdraw'))
							
							<select class="required form-control" id="action_sel" name="action_sel" style="display:none;">
				               <option value = "">{{ Lang::get('transaction.action_field') }}</option>
				               <option value = "1" {{ (\Input::get('action') == 'topup')?'selected':'' }}>{{ Lang::get('transaction.action_topup_field') }}</option>
				               <option value = "2" {{ (\Input::get('action') == 'withdraw')?'selected':'' }}>{{ Lang::get('transaction.action_withdraw_field') }}</option>
				            </select>
				            
					@else 
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.action_label') }}</label>
						<div class="col-md-9">
							
							<select class="required form-control" id="action_sel" name="action_sel" required>
				               <option value = "">{{ Lang::get('transaction.action_field') }}</option>
				               <option value = "1">{{ Lang::get('transaction.action_topup_field') }}</option>
				               <option value = "2">{{ Lang::get('transaction.action_withdraw_field') }}</option>
				            </select>
						</div>
					</div>						
					@endif
					@if(\Input::get('action') == 'topup')
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.user_field') }}</label>
						<div class="col-md-9">
							<select class="form-control" id="user_sel" name="user_sel" required>
								<option value=""></option>
							@foreach($user_list as $user)
								<option value="{{ $user->user_id }}">{{ $user->name }}</option>
							@endforeach
							</select>
						</div>
					</div>
					@elseif(\Input::get('action') == 'withdraw')
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.user_field') }}</label>
						<div class="col-md-9">
							<select class="form-control" id="user_sel" name="user_sel" onchange="changeUser($(this).val())" required>
								<option value=""></option>
							@foreach($user_list as $user)
								<option value="{{ $user->user_id }}">{{ $user->name }}</option>
							@endforeach
							</select>
						</div>
					</div>
					@endif
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.amount_field') }}</label>
						<div class="col-md-9">
							
							<input type="number" class="required form-control" id="amount_txt" name="amount_txt" value="{{ old('amount_txt') }}" placeholder="10000" required>
							
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.casino_label') }}</label>
						<div class="col-md-9">
							
							<select class="required form-control" id="casino_sel" name="casino_sel" onchange="changeCasino($('option:selected', this).val())" required>
								<option value = "">{{ Lang::get('transaction.casino_field') }}</option>
								@foreach($casino_list as $casino)
				               <option value = "{{ $casino->casino_id }}">{{ $casino->name }}</option>
				               @endforeach
				            </select>
				            
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.casino_username_label') }}</label>
						<div class="col-md-9">							
							<input type="text" class="required form-control" id="username_txt" name="username_txt" value="{{ old('username_txt') }}" placeholder="" required readonly />
						</div>
					</div>

					@if(\Input::get('action') == 'topup')
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_label') }}</label>
						<div class="col-md-9">
							
				            <select class="required form-control" id="bank_sel" name="bank_sel" onchange="changeBank($('option:selected', this).attr('data-company'))">
								<option value = "" selected>{{ Lang::get('user.bank_field') }}</option>
								@foreach($companybank_list as $bank)
									<option value = "{{ $bank->bank_id }}" data-company="{{ $bank->company_id }}">{{ $bank->bank_name }}</option>
								@endforeach
				            </select>
				            
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_account_field') }}</label>
						<div class="col-md-9">
							
				        	<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="" placeholder="{{ Lang::get('user.bank_account_field') }}" readonly>
							
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_fullname_field') }}</label>
						<div class="col-md-9">
							
				        	<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="" placeholder="{{ Lang::get('user.bank_fullname_field') }}" readonly>
							
						</div>
					</div>
					@elseif(\Input::get('action') == 'withdraw')
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_label') }}</label>
						<div class="col-md-9">
							
							<!--select class="required form-control" id="bank_sel" name="bank_sel" onchange="changeBank($('option:selected', this).attr('data-company'))">
								<option value = "" selected>{{ Lang::get('user.bank_field') }}</option>
								@foreach($companybank_list as $bank)
									<option value = "{{ $bank->bank_id }}" data-company="{{ $bank->company_id }}">{{ $bank->bank_name }}</option>
								@endforeach
				            </select-->
				        	<input type="text" class="required form-control" id="bank_name_txt" name="bank_name_txt" value="" placeholder="" required readonly>
				        	<input type="hidden" class="required form-control" id="bank_sel" name="bank_sel" value="" required readonly>
				            
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_account_field') }}</label>
						<div class="col-md-9">
							
				        	<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="" placeholder="{{ Lang::get('user.bank_account_field') }}" required readonly>
							
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_fullname_field') }}</label>
						<div class="col-md-9">
							
				        	<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="" placeholder="{{ Lang::get('user.bank_fullname_field') }}" required readonly>
							
						</div>
					</div>
					@endif



					@if(\Input::get('action') == 'topup')
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.receipt_image_field') }}</label>
						<div class="col-md-9">
							<input type="file" name="image" id="image" accept="image/*">
						</div>
					</div>
					@endif

					
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.remark_field') }}</label>
						<div class="col-md-9">
							
				        	<textarea class="required form-control" id="remark_txt" name="remark_txt" rows="3" cols="190" placeholder="{{ Lang::get('transaction.remark_field') }}" >{{ old('remark_txt') }}</textarea>
							
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
				
				<script>
					function changeBank(val) {
						for(var i = 0; i < companybank.length; i++) {
							var obj = companybank[i];
							//console.log(obj.id);
							if(obj.company_id == val) {
								$('#bank_fullname_txt').val(obj.bank_fullname);
								$('#bank_account_txt').val(obj.bank_account);
							}
						}
					}
					
					function changeUser(val) {
						$('#casino_sel').find('option').remove().end() .append('<option value=""></option>').val('');
						$('#username_txt').val('');
						for(var i = 0; i < userbank.length; i++) {
							var obj = userbank[i];
							//console.log(obj.id);
							if(obj.user_id == val) {
								$('#bank_sel').val(obj.bank_id);
								$('#bank_name_txt').val(obj.bank_name);
								$('#bank_fullname_txt').val(obj.bank_fullname);
								$('#bank_account_txt').val(obj.bank_account);
							}
						}
						
						for(var i=0; i<usercasino.length; i++) {
							var obj = usercasino[i];
							if(obj.user_id == val) {
								$('#casino_sel')
									.append($("<option></option>")
									.attr("value",obj.casino_id)
									.text(obj.casino_name)); 
							}
						}
					}
					
					function changeCasino(val) {
						var userid = $('#user_sel').val();
						$('#username_txt').val('');
						for(var i = 0; i < usercasino.length; i++) {
							var obj = usercasino[i];
							//console.log(obj.id);
							if(obj.casino_id == val && obj.user_id == userid) {
								$('#username_txt').val(obj.casino_no);
							}
						}
					}
					
					var companybank = [
					<?php $i = 0; ?>
					@foreach($companybank_list as $bank)
						{"company_id": "{{ $bank->company_id}}", "bank_account": "{{ $bank->bank_account }}", "bank_fullname":"{{ $bank->bank_fullname }}"}
						
						@if(($i+1) < count($companybank_list))
							{{ ',' }}
						@endif
						<?php $i++; ?>
					@endforeach
					];
					
					var userbank = [
					<?php $j = 0; ?>
					@foreach($user_list as $user)
						{"user_id": "{{ $user->user_id}}", "bank_id": "{{ $user->bank_id}}", "bank_name": "{{ $user->bank_name}}", "bank_account": "{{ $user->bank_account }}", "bank_fullname":"{{ $user->name }}"}
						@if(($j+1) < count($user_list))
							{{ ',' }}
						@endif
						<?php $j++; ?>
					@endforeach
					];
					
					var usercasino = [ 
					<?php $i = 0; ?>
					@foreach($casino_list as $casino)
						{"user_id": "{{ $casino->user_id}}", "casino_id": "{{ $casino->casino_id}}", "casino_name": "{{ $casino->name}}", "casino_no": "{{ $casino->casino_no }}"}
						
						@if(($i+1) < count($casino_list))
							{{ ',' }}
						@endif
						<?php $i++; ?>
					@endforeach
					];
				</script>
									
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