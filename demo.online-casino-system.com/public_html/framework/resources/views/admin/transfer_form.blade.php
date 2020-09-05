

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('transfer.transfer_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('user.name_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="user_name_txt" name="user_name_txt" value="{{ $transfer->user_name }}" readonly>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.from_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="from_txt" name="from_txt" value="{{ $transfer->from_name }}" readonly>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.to_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="to_txt" name="to_txt" value="{{ $transfer->to_name }}" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.amount_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="amount_txt" name="amount_txt" value="{{ $transfer->amount }}" readonly>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.transfer_date_field') }}</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="date_txt" name="date_txt" value="{{ $transfer->transfer_date }}" readonly>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.remark_field') }}</label>
						<div class="col-md-9">
							<textarea class="required form-control" id="remark_txt" name="remark_txt" rows="3" cols="190" placeholder="{{ Lang::get('transfer.remark_field') }}" readonly>{{ $transfer->remark }}</textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.comment_field') }}</label>
						<div class="col-md-9">
							<textarea class="form-control" name="comment_txt" id="comment_txt" rows="3" cols="190"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-2">
							<button type="submit" class="btn-success btn" value="submit" id="approve_btn" name="approve_btn">{{ Lang::get('general.approve_action') }}</button>
							<button type="submit" class="btn-success btn" value="submit" id="reject_btn" name="reject_btn">{{ Lang::get('general.reject_action') }}</button>
						</div>
					</div>
				</div>