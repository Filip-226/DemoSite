

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>{{ Lang::get('transfer.transfer_details_grid') }}</h2>
					<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body, .panel-footer"}'></div>
				</div>
				<div class="panel-body">

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.from_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<select class="required form-control" id="from_sel" name="from_sel" onchange="frChangeCasino($('option:selected', this).val())" required>
								<option value = "">{{ Lang::get('transfer.from_field') }}</option>
								@foreach($casino_list as $casino)
				               <option value = "{{ $casino->casino_id }}">{{ $casino->name }}</option>
				               @endforeach
				            </select>
							@else
							<select class="required form-control" id="from_sel" name="from_sel" onchange="frChangeCasino($('option:selected', this).val())" required>
								<option value = "">{{ Lang::get('transfer.from_field') }}</option>
								@foreach($casino_list as $casino)
				               <option value = "{{ $casino->casino_id }}" {{ (($transfer->from_acc == $casino->casino_id)?'selected':'') }}>{{ $casino->name }}</option>
				               @endforeach
				            </select>
							@endif
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.casino_username_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="from_username_txt" name="from_username_txt" value="{{ old('from_username_txt') }}" placeholder="" required readonly />
							@else
							<input type="text" class="required form-control" id="from_username_txt" name="from_username_txt" value="{{ $transfer->from_casino_no }}" placeholder="" required readonly />
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.to_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<select class="required form-control" id="to_sel" name="to_sel" onchange="toChangeCasino($('option:selected', this).val())" required>
								<option value = "">{{ Lang::get('transfer.to_field') }}</option>
								@foreach($casino_list as $casino)
				               <option value = "{{ $casino->casino_id }}">{{ $casino->name }}</option>
				               @endforeach
				            </select>
				            @else
				            <select class="required form-control" id="to_sel" name="to_sel" onchange="toChangeCasino($('option:selected', this).val())" required>
								<option value = "">{{ Lang::get('transfer.to_field') }}</option>
								@foreach($casino_list as $casino)
				               <option value = "{{ $casino->casino_id }}" {{ (($transfer->to_acc == $casino->casino_id)?'selected':'') }}>{{ $casino->name }}</option>
				               @endforeach
				            </select>
				            @endif
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transaction.casino_username_label') }}</label>
						<div class="col-md-9">
							@if($is_new)
							<input type="text" class="required form-control" id="to_username_txt" name="to_username_txt" value="{{ old('to_username_txt') }}" placeholder="" required readonly />
							@else
							<input type="text" class="required form-control" id="to_username_txt" name="to_username_txt" value="{{ $transfer->to_casino_no }}" placeholder="" required readonly />
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.amount_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<input type="number" class="required form-control" id="amount_txt" name="amount_txt" value="" placeholder="{{ Lang::get('transfer.amount_field') }}" >
							@else
							<input type="number" class="required form-control" id="amount_txt" name="amount_txt" value="{{ $transfer->amount }}" placeholder="{{ Lang::get('transfer.amount_field')}}" >
							@endif
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">{{ Lang::get('transfer.remark_field') }}</label>
						<div class="col-md-9">
							@if($is_new)
				        	<textarea class="required form-control" id="remark_txt" name="remark_txt" rows="3" cols="190" placeholder="{{ Lang::get('transfer.remark_field') }}" >{{ old('remark_txt') }}</textarea>
							@else
							<textarea class="required form-control" id="remark_txt" name="remark_txt" rows="3" cols="190" placeholder="{{ Lang::get('transfer.remark_field') }}" >{{ $transfer->remark }}</textarea>
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
					function frChangeCasino(val) {
						for(var i = 0; i < usercasino.length; i++) {
							var obj = usercasino[i];
							//console.log(obj.id);
							if(obj.casino_id == val) {
								$('#from_username_txt').val(obj.casino_no);
							}
						}
					}
					
					function toChangeCasino(val) {
						for(var i = 0; i < usercasino.length; i++) {
							var obj = usercasino[i];
							//console.log(obj.id);
							if(obj.casino_id == val) {
								$('#to_username_txt').val(obj.casino_no);
							}
						}
					}
					
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