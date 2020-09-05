@extends('template.app')

@section('sitestyle')

    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/plugins/datatables/dataTables.bootstrap.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/plugins/datatables/dataTables.themify.css"/>

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
								<li class="active">{{ Lang::get('general.transaction_history_page') }}</li>
							</ol>

							<form class="form-horizontal" role="form" method="GET" action="{{ url('/panel/history/actions') }}" id="history_action_form" name="history_action_form" data-url="{{ url('/') }}" >

							<input type="hidden" name="_token" value="{{ csrf_token() }}">

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
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h2>{{ Lang::get('transaction.history_table_grid') }}</h2>
													<div class="panel-ctrls"></div>
												</div>
												<div class="panel-body no-padding table-responsive">
													<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th width="2%">{{ Lang::get('general.grid_no') }}</th>
																<th width="13%">{{ Lang::get('user.name_field') }}</th>
																<th width="17%">{{ Lang::get('transaction.casino_label') }}</th>
																<th width="7%">{{ Lang::get('transaction.status_field') }}</th>
																<th width="7%">{{ Lang::get('transaction.transaction_label') }}</th>
																<th width="6%">{{ Lang::get('transaction.amount_field') }}</th>
																<th width="15%">{{ Lang::get('transaction.transaction_date_field') }}</th>
																<th width="15%">{{ Lang::get('transaction.verified_date_field') }}</th>
																<th width="18%">{{ Lang::get('transaction.action_label') }}</th>
															</tr>
														</thead>
														<tbody>
														<tr> 
															<td></td>
															<td>
																<input type="text" class="form-control" id="username_search_txt" name="username_search_txt" value="{{ Input::get('username_search_txt') }}" placeholder="{{ Lang::get('user.name_field') }}">
															</td>
															<td>
																<select class="form-control" id="casino_search_sel" name="casino_search_sel">
																	<option value = "">{{ Lang::get('transaction.casino_label') }}</option>
																	@foreach($casino_list as $casino)
													               <option value = "{{ $casino->casino_id }}" {{ (Input::get('casino_search_sel') == $casino->casino_id) ? 'selected': '' }} >{{ $casino->name }}</option>
													               @endforeach
													            </select>
															</td>
															<td>
																<select class="form-control" id="status_search_sel" name="status_search_sel">
																	<option value = "">{{ Lang::get('transaction.status_field') }}</option>
													               <option value = "1" {{ (Input::get('status_search_sel') == 1) ? 'selected': '' }} >{{ Lang::get('general.approve_action') }}</option>
													               <option value = "2" {{ (Input::get('status_search_sel') == 2) ? 'selected': '' }} >{{ Lang::get('general.reject_action') }}</option>
													            </select>
															</td>
															<td>
																<select class="form-control" id="action_search_sel" name="action_search_sel">
																	<option value = "">{{ Lang::get('transaction.action_label') }}</option>
													               <option value = "1" {{ (Input::get('action_search_sel') == 1) ? 'selected': '' }} >{{ Lang::get('transaction.action_topup_field') }}</option>
													               <option value = "2" {{ (Input::get('action_search_sel') == 2) ? 'selected': '' }} >{{ Lang::get('transaction.action_withdraw_field') }}</option>
													            </select>
															</td>
															<td>
																<input type="text" class="form-control" id="amount_search_txt" name="amount_search_txt" value="{{ Input::get('amount_search_txt') }}" placeholder="10000">
															</td>
															<td>
																<div class="col-md-6">
																	<select class="form-control" id="tyear_search_sel" name="tyear_search_sel">
																		<option value = "">{{ Lang::get('transaction.year_field') }}</option>
																		<?php
																			$current_year = (int)date('Y');
																			$date_difference = ($current_year - 2015) + 1;

																			for($counter = 0; $counter < $date_difference; $counter++)
																			{
																				$tyear = 2015 + $counter;
																				if(Input::get('tyear_search_sel') == $tyear)
																					echo "<option value = '". $tyear ."' selected>". $tyear ."</option>";
																				else
																					echo "<option value = '". $tyear ."'>". $tyear ."</option>";
																			}
																		?>
														            </select>
													        	</div>
													        	<div class="col-md-6">
														            <select class="form-control" id="tmonth_search_sel" name="tmonth_search_sel">
																		<option value = "">{{ Lang::get('transaction.month_field') }}</option>
																		<option value="01" {{ ((Input::get('tmonth_search_sel') == '01')?'selected':'') }}>1</option>
																		<option value="02" {{ ((Input::get('tmonth_search_sel') == '02')?'selected':'') }}>2</option>
																		<option value="03" {{ ((Input::get('tmonth_search_sel') == '03')?'selected':'') }}>3</option>
																		<option value="04" {{ ((Input::get('tmonth_search_sel') == '04')?'selected':'') }}>4</option>
																		<option value="05" {{ ((Input::get('tmonth_search_sel') == '05')?'selected':'') }}>5</option>
																		<option value="06" {{ ((Input::get('tmonth_search_sel') == '06')?'selected':'') }}>6</option>
																		<option value="07" {{ ((Input::get('tmonth_search_sel') == '07')?'selected':'') }}>7</option>
																		<option value="08" {{ ((Input::get('tmonth_search_sel') == '08')?'selected':'') }}>8</option>
																		<option value="09" {{ ((Input::get('tmonth_search_sel') == '09')?'selected':'') }}>9</option>
																		<option value="10" {{ ((Input::get('tmonth_search_sel') == '10')?'selected':'') }}>10</option>
																		<option value="11" {{ ((Input::get('tmonth_search_sel') == '11')?'selected':'') }}>11</option>
																		<option value="12" {{ ((Input::get('tmonth_search_sel') == '12')?'selected':'') }}>12</option>
														            </select>
													            </div>
															</td>
															<td>
																<div class="col-md-6">
																	<select class="form-control" id="vyear_search_sel" name="vyear_search_sel">
																		<option value = "">{{ Lang::get('transaction.year_field') }}</option>
																		<?php
																			$current_year = (int)date('Y');
																			$date_difference = ($current_year - 2015) + 1;

																			for($counter = 0; $counter < $date_difference; $counter++)
																			{
																				$vyear = 2015 + $counter;
																				if(Input::get('vyear_search_sel') == $vyear)
																					echo "<option value = '". $vyear ."' selected>". $vyear ."</option>";
																				else
																					echo "<option value = '". $vyear ."'>". $vyear ."</option>";
																			}
																		?>
														            </select>
													        	</div>
													        	<div class="col-md-6">
														            <select class="form-control" id="vmonth_search_sel" name="vmonth_search_sel">
																		<option value = "">{{ Lang::get('transaction.month_field') }}</option>
																		<option value="01" {{ ((Input::get('vmonth_search_sel') == '01')?'selected':'') }}>1</option>
																		<option value="02" {{ ((Input::get('vmonth_search_sel') == '02')?'selected':'') }}>2</option>
																		<option value="03" {{ ((Input::get('vmonth_search_sel') == '03')?'selected':'') }}>3</option>
																		<option value="04" {{ ((Input::get('vmonth_search_sel') == '04')?'selected':'') }}>4</option>
																		<option value="05" {{ ((Input::get('vmonth_search_sel') == '05')?'selected':'') }}>5</option>
																		<option value="06" {{ ((Input::get('vmonth_search_sel') == '06')?'selected':'') }}>6</option>
																		<option value="07" {{ ((Input::get('vmonth_search_sel') == '07')?'selected':'') }}>7</option>
																		<option value="08" {{ ((Input::get('vmonth_search_sel') == '08')?'selected':'') }}>8</option>
																		<option value="09" {{ ((Input::get('vmonth_search_sel') == '09')?'selected':'') }}>9</option>
																		<option value="10" {{ ((Input::get('vmonth_search_sel') == '10')?'selected':'') }}>10</option>
																		<option value="11" {{ ((Input::get('vmonth_search_sel') == '11')?'selected':'') }}>11</option>
																		<option value="12" {{ ((Input::get('vmonth_search_sel') == '12')?'selected':'') }}>12</option>
														            </select>
													            </div>
															</td>
															<td>
																<div class="col-md-6">
																	<select class="form-control" id="list_order_sel" name="list_order_sel">
				               											<option value = "asc" {{ (Input::get('list_order_sel') == "asc") ? 'selected': '' }} >{{ Lang::get('transaction.ascending_label') }}</option>
														               <option value = "desc" {{ (Input::get('list_order_sel') == "desc") ? 'selected': '' }} >{{ Lang::get('transaction.descending_label') }}</option>
														            </select>
																</div>
																<div class="col-md-6">
																	<input type="submit" class="btn btn-primary pull-left" value="{{ Lang::get('general.search_action') }}" id="search_btn" name="search_btn" class="btn-success btn" />
																</div>
															</td>
														</tr>
														<?php $i=1; ?>
														@foreach($history_list as $history)
															<tr> 
																<td>{{ $i }}</td>
																<td>{{$history->user_name}}</td>
																<td>{{$history->casino_name}}</td>
																<td>{{($history->is_verified == 1) ? Lang::get('general.approve_action') : Lang::get('general.reject_action')}}</td>
																<td>{{($history->action == 1) ? Lang::get('transaction.action_topup_field') : Lang::get('transaction.action_withdraw_field')}}</td>
																<td>{{$history->amount}}</td>
																<td>{{$history->transaction_date}}</td>
																<td>{{$history->verified_date}}</td>
																<td>
																	<a href="{{URL::to('/panel/history/view/' . $history->history_id)}}">{{ Lang::get('general.view_action') }}</a>
																</td>
															</tr>
															<?php $i++; ?>
														@endforeach
														</tbody>
													</table>
												</div>
												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-2">
															<div class="dataTables_info" id="example_info" role="status" aria-live="polite"></div>
														</div>
														<div class="col-sm-4"></div>
														<div class="col-sm-6">
															<div class="dataTables_paginate paging_bootstrap" id="example_paginate">
																<?php echo $history_list->appends(Input::except('page'))->render(); ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> <!-- .container-fluid -->
							</form>

@endsection

@section('sitescript')

@endsection