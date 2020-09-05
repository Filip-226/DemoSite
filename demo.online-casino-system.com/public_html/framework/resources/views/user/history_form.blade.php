

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('transaction.history_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.name_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="user_name_txt" name="user_name_txt" value="{{ $history->user_name }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.email_address_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="user_email_txt" name="user_email_txt" value="{{ $history->user_email }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.action_label') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="transaction_action_txt" name="transaction_action_txt" value="{{ ($history->action == 1) ? 'Topup' : 'Withdraw' }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.amount_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="transaction_amount_txt" name="transaction_amount_txt" value="{{ $history->amount }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.casino_label') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="casino_name_txt" name="casino_name_txt" value="{{ $history->casino_name }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_label') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="bank_name_txt" name="bank_name_txt" value="{{ $history->bank_name }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_account_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="bank_account_txt" name="bank_account_txt" value="{{ $history->bank_account }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.bank_fullname_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="bank_fullname_txt" name="bank_fullname_txt" value="{{ $history->bank_fullname }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.transaction_date_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="transaction_date_txt" name="transaction_date_txt" value="{{ $history->transaction_date }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.verified_date_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="verified_date_txt" name="verified_date_txt" value="{{ $history->verified_date }}" readonly>
						</div>
					</div>

					@if($history->image_location != null)
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.uploaded_image_field') }}</label>
						<div class="col-md-9">
							<a href="{{ url::to('/') . '/images/upload/transaction/' . str_replace('\\', '/', $history->image_location) }}" data-smoothzoom="group1">
								<img src="{{ url::to('/') . '/images/upload/transaction/' . str_replace('\\', '/', $history->image_location) }}" id="uploaded_image_img" name="uploaded_image_img" alt="{{ Lang::get('transaction.uploaded_image_field') }}">
							</a>
						</div>
					</div>
					@endif
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.remark_field') }}</label>
						<div class="col-md-9">
							<textarea class="required form-control" id="remark_txt" name="remark_txt" rows="3" cols="190" placeholder="{{ Lang::get('transaction.remark_field') }}" readonly>{{ $history->remark }}</textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.comment_field') }}</label>
						<div class="col-md-9">
							<textarea name="comment_txt" id="comment_txt" rows="3" cols="190" class="form-control" readonly>{{ $history->comment }}</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
