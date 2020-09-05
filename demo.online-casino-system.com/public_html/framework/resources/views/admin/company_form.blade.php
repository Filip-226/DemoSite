

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('bank.bank_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('bank.bank_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<select class="required form-control" id="bank_sel" name="bank_sel" required>
								<option value = "">{{ Lang::get('bank.bank_field') }}</option>
								@foreach($bank_list as $bank)
				               <option value = "{{ $bank->bank_id }}">{{ $bank->name }}</option>
				               @endforeach
				            </select>
				            @else
				            <select class="required form-control" id="bank_sel" name="bank_sel" required>
								<option value = "">{{ Lang::get('bank.bank_field') }}</option>
								@foreach($bank_list as $bank)
				               <option value = "{{ $bank->bank_id }}" {{ (($company_bank->bank_id == $bank->bank_id)?'selected':'') }}>{{ $bank->name }}</option>
				               @endforeach
				            </select>
				            @endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('company.bank_account_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ old('bank_account_txt') }}" placeholder="{{ Lang::get('company.bank_account_field') }}" required>
							@else
							<input type="number" class="required form-control" id="bank_account_txt" name="bank_account_txt" value="{{ $company_bank->bank_account }}" placeholder="{{ Lang::get('company.bank_account_field') }}" required>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('company.bank_fullname_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ old('bank_fullname_txt') }}" placeholder="{{ Lang::get('company.bank_fullname_field') }}" required>
							@else
							<input type="text" class="required form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ $company_bank->bank_fullname }}" placeholder="{{ Lang::get('company.bank_fullname_field') }}" required>
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