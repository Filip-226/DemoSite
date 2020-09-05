

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('transaction.transaction_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					@if(\Input::get('action') != "" && (\Input::get('action') == 'topup' || \Input::get('action') == 'withdraw'))
							@if($is_new)
							<select class="required form-control" id="action_sel" name="action_sel" style="display:none;">
				               <option value = "">{{ Lang::get('transaction.action_field') }}</option>
				               <option value = "1" {{ (\Input::get('action') == 'topup')?'selected':'' }}>{{ Lang::get('transaction.action_topup_field') }}</option>
				               <option value = "2" {{ (\Input::get('action') == 'withdraw')?'selected':'' }}>{{ Lang::get('transaction.action_withdraw_field') }}</option>
				            </select>
				            @endif
					@else 

							@if($is_new)
							<select class="required form-control" id="action_sel" name="action_sel" required>
				               <option value = "">{{ Lang::get('transaction.action_field') }}</option>
				               <option value = "1">{{ Lang::get('transaction.action_topup_field') }}</option>
				               <option value = "2">{{ Lang::get('transaction.action_withdraw_field') }}</option>
				            </select>
				            @else
				            <select class="required form-control" id="action_sel" name="action_sel" style="display:none;" required>
				               <option value = "">{{ Lang::get('transaction.action_field') }}</option>
				               <option value = "1" {{ (($transaction->action == 1)?'selected':'') }}>{{ Lang::get('transaction.action_topup_field') }}</option>
				               <option value = "2" {{ (($transaction->action == 2)?'selected':'') }}>{{ Lang::get('transaction.action_withdraw_field') }}</option>
				            </select>
				            @endif
					@endif

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.amount_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="number" class="required form-control" id="amount_txt" name="amount_txt" value="{{ old('amount_txt') }}" placeholder="10000" required>
							@else
							<input type="number" class="required form-control" id="amount_txt" name="amount_txt" value="{{ $transaction->amount }}" placeholder="10000" required>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.casino_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<select class="required form-control" id="casino_sel" name="casino_sel" onchange="changeCasino($('option:selected', this).val())" required>
								<option value = "">{{ Lang::get('transaction.casino_field') }}</option>
								@foreach($casino_list as $casino)
								<option value = "{{ $casino->casino_id }}">{{ $casino->name }}</option>
								@endforeach
				            </select>
				            @else
				            <select class="required form-control" id="casino_sel" name="casino_sel" required>
								<option value = "">{{ Lang::get('transaction.casino_field') }}</option>
								@foreach($casino_list as $casino)
								<option value = "{{ $casino->casino_id }}" {{ (($transaction->casino_id == $casino->casino_id)?'selected':'') }}>{{ $casino->name }}</option>
								@endforeach
				            </select>
				            @endif
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.casino_username_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="username_txt" name="username_txt" value="{{ old('username_txt') }}" placeholder="" required readonly />
							@else
							<input type="text" class="required form-control" id="username_txt" name="username_txt" value="{{ $transaction->casino_no }}" placeholder="" required readonly />
							@endif
						</div>
					</div>

					@if(\Input::get('action') == 'topup')
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
				            <select class="required form-control" id="bank_sel" name="bank_sel" onchange="changeBank($('option:selected', this).attr('data-company'))" required>
								<option value = "" selected>{{ Lang::get('user.bank_field') }}</option>
								@foreach($companybank_list as $bank)
									<option value = "{{ $bank->bank_id }}" data-company="{{ $bank->company_id }}">{{ $bank->bank_name }}</option>
								@endforeach
				            </select>
				            @else
				            <select class="required form-control" id="bank_sel" name="bank_sel" readonly disabled>
								<option value = "">{{ Lang::get('user.bank_field') }}</option>
								@foreach($companybank_list as $bank)
				               <option value = "{{ $bank->bank_id }}" {{ (($transaction->bank_id == $bank->bank_id)?'selected':'') }}>{{ $bank->bank_name }}</option>
				               @endforeach
				            </select>
				            @endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_account_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="" placeholder="{{ Lang::get('user.bank_account_field') }}" readonly>
							@else
							<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ $transaction->bank_account }}" placeholder="1234567890" readonly>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_fullname_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="" placeholder="{{ Lang::get('user.bank_fullname_field') }}" readonly>
							@else
							<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ $transaction->bank_fullname }}" placeholder="{{ Lang::get('user.bank_fullname_field') }}" readonly>
							@endif
						</div>
					</div>
					@elseif(\Input::get('action') == 'withdraw')
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
				            <!--select class="required form-control" id="bank_sel" name="bank_sel" onchange="changeBank($('option:selected', this).attr('data-company'))">
								<option value = "" selected>{{ Lang::get('user.bank_field') }}</option>
								@foreach($companybank_list as $bank)
								<option value = "{{ $bank->bank_id }}" data-company="{{ $bank->company_id }}">{{ $bank->bank_name }}</option>
								@endforeach
				            </select-->
				            <select class="required form-control" id="bank_name" name="bank_name" disabled readonly>
								<option value = "">{{ Lang::get('user.bank_field') }}</option>
								@foreach($bank_list as $bank)
				               <option value = "{{ $bank->bank_id }}" {{ ( Auth::user()->bank_id == $bank->bank_id )?'selected':'' }}>{{ $bank->name }}</option>
				               @endforeach
				            </select>
				        	<input type="hidden" class="required form-control" id="bank_sel" name="bank_sel" value="{{ Auth::user()->bank_id }}" required readonly>
				            @else
				            <!--select class="required form-control" id="bank_sel" name="bank_sel" readonly disabled>
								<option value = "">{{ Lang::get('user.bank_field') }}</option>
								@foreach($companybank_list as $bank)
								<option value = "{{ $bank->bank_id }}" {{ (($transaction->bank_id == $bank->bank_id)?'selected':'') }}>{{ $bank->bank_name }}</option>
								@endforeach
				            </select-->
				        	<input type="text" class="required form-control" id="bank_name_txt" name="bank_name_txt" value="" placeholder="" required readonly>
				        	<input type="hidden" class="required form-control" id="bank_sel" name="bank_sel" value="" required readonly>
				            @endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_account_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ Auth::user()->bank_account }}" placeholder="{{ Lang::get('user.bank_account_field') }}" readonly>
							@else
							<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ $transaction->bank_account }}" placeholder="1234567890" readonly>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_fullname_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ Auth::user()->name }}" placeholder="{{ Lang::get('user.bank_fullname_field') }}" readonly>
							@else
							<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ $transaction->bank_fullname }}" placeholder="{{ Lang::get('user.bank_fullname_field') }}" readonly>
							@endif
						</div>
					</div>
					@else 
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
				            <select class="required form-control" id="bank_sel" name="bank_sel" onchange="changeBank($('option:selected', this).attr('data-company'))">
								<option value = "" selected>{{ Lang::get('user.bank_field') }}</option>
								@foreach($companybank_list as $bank)
									<option value = "{{ $bank->bank_id }}" data-company="{{ $bank->company_id }}">{{ $bank->bank_name }}</option>
								@endforeach
				            </select>
				            @else
				            <select class="required form-control" id="bank_sel" name="bank_sel" readonly disabled>
								<option value = "">{{ Lang::get('user.bank_field') }}</option>
								@foreach($bank_list as $bank)
				               <option value = "{{ $bank->bank_id }}" {{ (($transaction->bank_id == $bank->bank_id)?'selected':'') }}>{{ $bank->name }}</option>
				               @endforeach
				            </select>
				            @endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_account_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="" placeholder="{{ Lang::get('user.bank_account_field') }}" readonly>
							@else
							<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ $transaction->bank_account }}" placeholder="1234567890" readonly>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_fullname_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="" placeholder="{{ Lang::get('user.bank_fullname_field') }}" readonly>
							@else
							<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ $transaction->bank_fullname }}" placeholder="{{ Lang::get('user.bank_fullname_field') }}" readonly>
							@endif
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

					@if(!$is_new)
						@if($transaction->image_location != null)
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.uploaded_image_field') }}</label>
						<div class="col-md-9">
							<a href="{{ url::to('/') . '/images/upload/transaction/' . str_replace('\\', '/', $transaction->image_location) }}" data-smoothzoom="group1">
								<img src="{{ url::to('/') . '/images/upload/transaction/' . str_replace('\\', '/', $transaction->image_location) }}" id="uploaded_image_img" name="uploaded_image_img" alt="{{ Lang::get('transaction.uploaded_image_field') }}">
							</a>
						</div>
					</div>
						@endif
					@endif
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.remark_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<textarea class="required form-control" id="remark_txt" name="remark_txt" rows="3" cols="190" placeholder="{{ Lang::get('transaction.remark_field') }}" >{{ old('remark_txt') }}</textarea>
							@else
							<textarea class="required form-control" id="remark_txt" name="remark_txt" rows="3" cols="190" placeholder="{{ Lang::get('transaction.remark_field') }}" >{{ $transaction->remark }}</textarea>
							@endif
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
					
					function changeCasino(val) {
						for(var i = 0; i < usercasino.length; i++) {
							var obj = usercasino[i];
							//console.log(obj.id);
							if(obj.casino_id == val) {
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
					
					var usercasino = [ 
					<?php $i = 0; ?>
					@foreach($casino_list as $casino)
						{"casino_id": "{{ $casino->casino_id}}", "casino_no": "{{ $casino->casino_no }}"}
						
						@if(($i+1) < count($casino_list))
							{{ ',' }}
						@endif
						<?php $i++; ?>
					@endforeach
					];
				</script>