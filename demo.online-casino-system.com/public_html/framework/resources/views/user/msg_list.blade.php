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
								<li class="active">{{ Lang::get('general.inbox_manage_page') }}</li>
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
													<h2>{{ $subject }}</h2>
													<div class="panel-ctrls"><a href="{{ URL::route('user.inbox_reply', array($msg_id)) }}" class="btn-success btn">Reply</a></div>
												</div>
												<div class="panel-body no-padding table-responsive">
													
														<?php $i=1; ?>
														@foreach($msg_list as $msg)
															<?php 
																$row = (($i%2 == 0)?'tbl-row':''); 
															?>
															<div id="msg_{{$msg->inbox_id}}" class="{{ $row }}" style="padding: 10px; clear:both; display: flex;border-bottom: 1px solid #e3e3e3;" onclick="showDesc('msg_{{$msg->inbox_id}}')"> 
																<div style="float:left; width:100%">
																<div><b>{{$msg->name}}</b></div>
																<div class="short-desc">{{ substr($msg->inbox_msg, 0, 20) . '...' }}</div>
																<div class="long-desc" style="display:none;"><?php echo nl2br($msg->inbox_msg); ?></div>
																</div>
																<div style="float:right; top:0">{{$msg->created_at}}</div>

															</div>
															<?php $i++; ?>
														@endforeach
														
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
																<?php echo $msg_list->appends(Input::except('page'))->render(); ?>
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
<script>
	function showDesc(msgbox) {
		$('.short-desc').show();
		$('.long-desc').hide();
		if($('#' + msgbox).find('.short-desc').css('display') == 'none') {
			$('#' + msgbox).find('.short-desc').show();
			$('#' + msgbox).find('.long-desc').hide();
		} else {
			$('#' + msgbox).find('.short-desc').hide();
			$('#' + msgbox).find('.long-desc').show();
		}
	}
</script>

@endsection