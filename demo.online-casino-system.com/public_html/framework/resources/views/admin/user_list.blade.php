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
								<li class="active">{{ Lang::get('general.user_manage_page') }}</li>
							</ol>

							<form class="form-horizontal" role="form" method="GET" action="{{ url('/panel/admin/user/actions') }}" id="user_action_form" name="user_action_form" data-url="{{ url('/') }}" >

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
													<h2>{{ Lang::get('user.user_table_grid') }}</h2>
													<div class="panel-ctrls"></div>
												</div>
												<div class="panel-body no-padding table-responsive">
													<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>{{ Lang::get('general.grid_no') }}</th>
																<th>{{ Lang::get('user.name_field') }}</th>
																<th>{{ Lang::get('user.contact_no_field') }}</th>
																<th>{{ Lang::get('user.email_address_field') }}</th>
																<th>{{ Lang::get('user.ipaddress_field') }}</th>
																<th>{{ Lang::get('user.register_date_field') }}</th>
																<th>{{ Lang::get('general.action') }}</th>
															</tr>
														</thead>
														<tbody>
														<tr> 
															<td></td>
															<td>
																<input type="text" class="form-control" id="username_search_txt" name="username_search_txt" value="{{ Input::get('username_search_txt') }}" placeholder="{{ Lang::get('user.name_field') }}">
															</td>
															<td>
																<input type="text" class="form-control" id="usercontact_search_txt" name="usercontact_search_txt" value="{{ Input::get('usercontact_search_txt') }}" placeholder="{{ Lang::get('user.contact_no_field') }}">
															</td>
															<td>
																<input type="text" class="form-control" id="useremail_search_txt" name="useremail_search_txt" value="{{ Input::get('useremail_search_txt') }}" placeholder="{{ Lang::get('user.email_address_field') }}">
															</td>
															<td>
																<input type="text" class="form-control" id="userip_search_txt" name="userip_search_txt" value="{{ Input::get('userip_search_txt') }}" placeholder="{{ Lang::get('user.ipaddress_field') }}">
															</td>
															<td>
															</td>
															<td>
																<input type="submit" class="btn btn-primary pull-left" value="{{ Lang::get('general.search_action') }}" id="search_btn" name="search_btn" class="btn-success btn" />
															</td>
														</tr>
														<?php $i=1; ?>
														@foreach($user_list as $user)
															<tr> 
																<td>{{$i}}</td>
																<td>{{$user->name}}</td>
																<td>{{$user->contact_no}}</td>
																<td>{{$user->email}}</td>
																<td>{{$user->ip_address}}</td>
																<td>{{ $user->created_at }}</td>
																<td>
																	<a href="{{URL::to('/panel/admin/user/inbox/' . $user->user_id)}}">{{ Lang::get('general.inbox_action') }}</a> | 
																	<a href="{{URL::to('/panel/admin/user/edit/' . $user->user_id)}}">{{ Lang::get('general.edit_action') }}</a> | 
																	<a href="{{URL::to('/panel/admin/user/delete/' . $user->user_id)}}" onclick="return confirm('{{ Lang::get('user.delete_msg') }} ({{$user->name}})?');">{{ Lang::get('general.delete_action') }}</a>
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
																<?php echo $user_list->appends(Input::except('page'))->render(); ?>
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