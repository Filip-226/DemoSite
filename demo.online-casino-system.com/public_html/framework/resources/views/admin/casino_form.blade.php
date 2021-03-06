

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('casino.casino_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('casino.name_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="name_txt" name="name_txt" value="{{ old('name_txt') }}" placeholder="{{ Lang::get('casino.name_field') }}" required>
							@else
							<input type="text" class="required form-control" id="name_txt" name="name_txt" value="{{ $casino->name }}" placeholder="{{ Lang::get('casino.name_field') }}" required>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('casino.fullname_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="fullname_txt" name="fullname_txt" value="{{ old('fullname_txt') }}" placeholder="{{ Lang::get('casino.fullname_field') }}" required>
							@else
							<input type="text" class="required form-control" id="fullname_txt" name="fullname_txt" value="{{ $casino->fullname }}" placeholder="{{ Lang::get('casino.fullname_field') }}" required>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('casino.isenabled_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="checkbox" name="isenabled_chk" id="isenabled_chk" value="1" />
							@else
							<input type="checkbox" name="isenabled_chk" id="isenabled_chk" value="1" <?php if((bool)$casino->is_enabled) echo "Checked"; ?> />
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