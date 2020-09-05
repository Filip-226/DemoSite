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
								<li class="active">{{ Lang::get('bank.manage_bank_action') }}</li>
							</ol>

							<form class="form-horizontal" role="form" method="GET" action="{{ url('/panel/admin/bank/actions') }}" id="bank_action_form" name="bank_action_form" data-url="{{ url('/') }}" >

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
													<h2>{{ Lang::get('bank.bank_table_grid') }}</h2>
													<div class="panel-ctrls"></div>
												</div>
												<div class="panel-body no-padding table-responsive">
													<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>{{ Lang::get('general.grid_no') }}</th>
																<th>{{ Lang::get('bank.bank_name_field') }}</th>
																<th>{{ Lang::get('general.action') }}</th>
															</tr>
														</thead>
														<tbody>
														<tr> 
															<td></td>
															<td>
																<input type="text" class="form-control" id="bankname_search_txt" name="bankname_search_txt" value="{{ Input::get('bankname_search_txt') }}" placeholder="Bank">
															</td>
															<td>
																<input type="submit" class="btn btn-primary pull-left" value="{{ Lang::get('general.search_action') }}" id="search_btn" name="search_btn" class="btn-success btn" />
															</td>
														</tr>
														<?php $i=1; ?>
														@foreach($bank_list as $bank)
															<tr> 
																<td>{{$i}}</td>
																<td>{{$bank->name}}</td>
																<td>
																	<a href="{{URL::to('/panel/admin/bank/edit/' . $bank->bank_id)}}">{{ Lang::get('general.edit_action') }}</a> | 
																	<a href="{{URL::to('/panel/admin/bank/delete/' . $bank->bank_id)}}" onclick="return confirm('{{ Lang::get('bank.delete_msg') }} ({{$bank->name}})?');">{{ Lang::get('general.delete_action') }}</a>
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
														<div class="col-sm-4">
														</div>
														<div class="col-sm-6">
															<div class="dataTables_paginate paging_bootstrap" id="example_paginate">
																<?php echo $bank_list->appends(Input::except('page'))->render(); ?>
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