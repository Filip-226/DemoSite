

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('user.user_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.name_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="name_txt" name="name_txt" value="{{ old('name_txt') }}" placeholder="{{ Lang::get('user.name_field') }}" required>
							@else
							<input type="text" class="required form-control" id="name_txt" name="name_txt" value="{{ $user->name }}" placeholder="{{ Lang::get('user.name_field') }}" required>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.email_address_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="email" class="required form-control" id="email_txt" name="email_txt" value="{{ old('email_txt') }}" placeholder="{{ Lang::get('user.email_address_field') }}" required>
							@else
							<input type="email" class="required form-control" id="email_txt" name="email_txt" value="{{ $user->email }}" placeholder="{{ Lang::get('user.email_address_field') }}" required>
							@endif
							
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.password_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="password" class="required form-control" id="password_txt" name="password_txt" value="{{ old('password_txt') }}" placeholder="{{ Lang::get('user.password_field') }}" required minlength="8">
							@else
							<input type="password" class="required form-control" id="password_txt" name="password_txt" value="12345" placeholder="{{ Lang::get('user.password_field') }}" required minlength="8">
							@endif
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.contact_no_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="contact_txt" name="contact_txt" value="{{ old('contact_txt') }}" placeholder="{{ Lang::get('user.contact_no_field') }}" required maxlength="20">
							@else
							<input type="text" class="required form-control" id="contact_txt" name="contact_txt" value="{{ $user->contact_no }}" placeholder="{{ Lang::get('user.contact_no_field') }}" required maxlength="20">
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<select class="required form-control" id="bank_sel" name="bank_sel" >
								<option value = "">{{ Lang::get('user.bank_field') }}</option>
								@foreach($bank_list as $bank)
				               <option value = "{{ $bank->bank_id }}">{{ $bank->name }}</option>
				               @endforeach
				            </select>
				            @else
				            <select class="required form-control" id="bank_sel" name="bank_sel" >
								<option value = "">{{ Lang::get('user.bank_field') }}</option>
								@foreach($bank_list as $bank)
				               <option value = "{{ $bank->bank_id }}" {{ (($user->bank_id == $bank->bank_id)?'selected':'') }}>{{ $bank->name }}</option>
				               @endforeach
				            </select>
				            @endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_account_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ old('bank_account_txt') }}" placeholder="{{ Lang::get('user.bank_account_field') }}" >
							@else
							<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ $user->bank_account }}" placeholder="{{ Lang::get('user.bank_account_field') }}" >
							@endif
						</div>
					</div>

					<!--div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_fullname_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ old('bank_fullname_txt') }}" placeholder="Full Name" >
							@else
							<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ $user->bank_fullname }}" placeholder="Full Name" >
							@endif
						</div>
					</div-->

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.is_admin_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="checkbox" name="isadmin_chk" id="isadmin_chk" value="1" />
							@else
							<input type="checkbox" name="isadmin_chk" id="isadmin_chk" value="1" <?php if((bool)$user->is_admin) echo "Checked"; ?> />
							@endif
						</div>
					</div>

					<?php
						$pendingToVerify = false;
						if($is_new){
							$pendingToVerify = true;
						}else{
							if(!(bool)$user->is_verified)
								$pendingToVerify = true;
						}
					?>
					@if($pendingToVerify)
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.is_verified_field') }}</label>
						<div class="col-md-9">
							<input type="checkbox" name="isverified_chk" id="isverified_chk" value="1" />
						</div>
					</div>
					@else 
						<input type="hidden" name="isverified_chk" id="isverified_chk" value="1" />
					@endif
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.casino_field') }} <a href="javascript:void(0);" onclick="appendProduct()"><i class="fa fa-plus-circle"></i></a></label>
						<div class="col-md-9">
							<div id="user_products">
							@if($is_new)
								<div class="form-group">
									<div class="col-md-5">
										<select name="casino_id[]" id="casino_id1" class="required form-control" required>
											@foreach($casino_list as $casino)
											<option value="{{ $casino->casino_id}}">{{ $casino->name}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-6">
										<input type="text" name="casino_no[]" id="casino_no1" value="" class="required form-control" required />
										<input type="hidden" name="casino_row[]" id="casino_row1" value="" class="form-control" />
									</div>
									<div class="col-md-1">
										<a href="javascript: void(0);" onclick="$(this).parent().parent().remove('.form-group');"><i class="fa fa-minus-circle"></i></a>
									</div>
								</div>
							@else
								@if(count($usercasino_list) > 0)
									<?php $i = 1; ?>
									@foreach($usercasino_list as $usercasino)
								<div class="form-group">
									<div class="col-md-5">
										<select name="casino_id[]" id="casino_id{{$i}}" class="required form-control" required>
											@foreach($casino_list as $casino)
											<option value="{{ $casino->casino_id}}" {{ ($casino->casino_id == $usercasino->casino_id?'selected':'') }}>{{ $casino->name}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-6">
										<input type="text" name="casino_no[]" id="casino_no{{$i}}" value="{{ $usercasino->casino_no}}" class="required form-control" required />
										<input type="hidden" name="casino_row[]" id="casino_row{{$i}}" value="{{ $usercasino->user_casino_id}}" class="form-control" />
									</div>
									<div class="col-md-1">
										<a href="javascript: void(0);" onclick="$(this).parent().parent().remove('.form-group');"><i class="fa fa-minus-circle"></i></a>
									</div>
								</div>
									<?php $i++; ?>
									@endforeach
								@else
								<div class="form-group">
									<div class="col-md-5">
										<select name="casino_id[]" id="casino_id" class="required form-control" required>
											@foreach($casino_list as $casino)
											<option value="{{ $casino->casino_id}}">{{ $casino->name}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-6">
										<input type="text" name="casino_no[]" id="casino_no1" value="" class="required form-control" required />
									</div>
									<div class="col-md-1">
										<a href="javascript: void(0);" onclick="$(this).parent().parent().remove('.form-group');"><i class="fa fa-minus-circle"></i></a>
									</div>
								</div>
								@endif
							@endif
							</div>
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