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
								<li class="active">{{ Lang::get('general.transaction_verify_page') }}</li>
							</ol>

							<form class="form-horizontal" role="form" method="GET" action="{{ url('/panel/admin/transaction/actions') }}" id="transaction_action_form" name="transaction_action_form" data-url="{{ url('/') }}" >

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
													<h2>{{ Lang::get('transaction.transaction_table_grid') }}</h2>
													<div class="panel-ctrls"></div>
												</div>
												<div class="panel-body no-padding table-responsive">
													<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th width="5%">{{ Lang::get('general.grid_no') }}</th>
																<th width="17%">{{ Lang::get('user.name_field') }}</th>
																<th width="23%">{{ Lang::get('transaction.casino_label') }}</th>
																<th width="10%">{{ Lang::get('transaction.transaction_label') }}</th>
																<th width="10%">{{ Lang::get('transaction.amount_field') }}</th>
																<th width="16%">{{ Lang::get('transaction.date_field') }}</th>
																<th width="19%">{{ Lang::get('transaction.action_label') }}</th>
															</tr>
														</thead>
														<tbody>
														<tr> 
															<td></td>
															<td>
																<input type="text" class="form-control" id="username_search_txt" name="username_search_txt" value="{{ Input::get('username_search_txt') }}" placeholder="{{ Lang::get('user.name_field') }}">
															</td>
															<td>
																<select class="form-control" id="casinoname_search_sel" name="casinoname_search_sel">
																	<option value = "">{{ Lang::get('transaction.casino_label') }}</option>
																	@foreach($casino_list as $casino)
													               <option value = "{{ $casino->casino_id }}" {{ (Input::get('casino_search_sel') == $casino->casino_id) ? 'selected': '' }} >{{ $casino->name }}</option>
													               @endforeach
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
																	<select class="form-control" id="year_search_sel" name="year_search_sel">
																		<option value = "">{{ Lang::get('transaction.year_field') }}</option>
																		<?php
																			$current_year = (int)date('Y');
																			$date_difference = ($current_year - 2015) + 1;

																			for($counter = 0; $counter < $date_difference; $counter++)
																			{
																				$year = 2015 + $counter;
																				if(Input::get('year_search_sel') == $year)
																					echo "<option value = '". $year ."' selected>". $year ."</option>";
																				else
																					echo "<option value = '". $year ."'>". $year ."</option>";
																			}
																		?>
														            </select>
													        	</div>
													        	<div class="col-md-6">
														            <select class="form-control" id="month_search_sel" name="month_search_sel">
																		<option value = "">{{ Lang::get('transaction.month_field') }}</option>
																		<option value="01" {{ ((Input::get('month_search_sel') == '01')?'selected':'') }}>1</option>
																		<option value="02" {{ ((Input::get('month_search_sel') == '02')?'selected':'') }}>2</option>
																		<option value="03" {{ ((Input::get('month_search_sel') == '03')?'selected':'') }}>3</option>
																		<option value="04" {{ ((Input::get('month_search_sel') == '04')?'selected':'') }}>4</option>
																		<option value="05" {{ ((Input::get('month_search_sel') == '05')?'selected':'') }}>5</option>
																		<option value="06" {{ ((Input::get('month_search_sel') == '06')?'selected':'') }}>6</option>
																		<option value="07" {{ ((Input::get('month_search_sel') == '07')?'selected':'') }}>7</option>
																		<option value="08" {{ ((Input::get('month_search_sel') == '08')?'selected':'') }}>8</option>
																		<option value="09" {{ ((Input::get('month_search_sel') == '09')?'selected':'') }}>9</option>
																		<option value="10" {{ ((Input::get('month_search_sel') == '10')?'selected':'') }}>10</option>
																		<option value="11" {{ ((Input::get('month_search_sel') == '11')?'selected':'') }}>11</option>
																		<option value="12" {{ ((Input::get('month_search_sel') == '12')?'selected':'') }}>12</option>
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
														@foreach($transaction_list as $transaction)
															<tr> 
																<td><input type="checkbox" name="transaction_list[]" id="transaction_list[]" value="{{ $transaction->transaction_id }}"></td>
																<td>{{$transaction->user_name}}</td>
																<td>{{$transaction->casino_name}} ({{$transaction->casino_no}})</td>
																<td>{{($transaction->action == 1) ? Lang::get('transaction.action_topup_field') : Lang::get('transaction.action_withdraw_field')}}</td>
																<td>{{$transaction->amount}}</td>
																<td>{{$transaction->transaction_date}}</td>
																<td>
																	<a href="{{URL::to('/panel/admin/transaction/verify/' . $transaction->transaction_id)}}">{{ Lang::get('general.verify_action') }}</a>
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
															<input type="submit" class="btn btn-primary pull-left" value="{{ Lang::get('general.approve_action') }}" id="approve_btn" name="approve_btn" class="btn-success btn" />
															<input type="submit" class="btn btn-primary pull-left" value="{{ Lang::get('general.reject_action') }}" id="reject_btn" name="reject_btn" class="btn-success btn" />
														</div>
														<div class="col-sm-4">
															<div class="col-sm-2">{{ Lang::get('transaction.comment_field') }}</div>
															<div class="col-sm-10">
																<textarea name="comment_txt" id="comment_txt" rows="3" cols="80"></textarea>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="dataTables_paginate paging_bootstrap" id="example_paginate">
																<?php echo $transaction_list->appends(Input::except('page'))->render(); ?>
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