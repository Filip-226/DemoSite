@extends('template.app')

@section('header')
	@include('template.header')
@endsection

@section('sidebar')
	@include('template.sidebar')
@endsection

@section('content')
<ol class="breadcrumb">                
	<li class=""><a href="{{URL::route('index')}}">{{ Lang::get('general.home_page') }}</a></li>
	<li class="active">{{ Lang::get('general.dashboard_page') }}</li>
</ol>
<div class="container-fluid">
			@if((bool)Auth::user()->is_admin)
			<div class="col-md-4">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ Lang::get('dashboard.pending_users_section') }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 320px;">
						<div class="scroll-content">
							<ul class="mini-timeline">
								@foreach($pending_user_list as $new_user)
								<li class="mini-timeline-lime">
									<div class="timeline-icon"></div>
									<div class="timeline-body">
										<div class="timeline-content">
											<a href="{{ url('/panel/admin/user/edit/' . $new_user->user_id) }}" class="name">{{ $new_user->name }}</a>
											<span class="time">{{ $new_user->created_at }}</span>
										</div>
									</div>
								</li>
								@endforeach
								<li class="mini-timeline-default">
									<div class="timeline-body ml-n">
										<div class="timeline-content">
											<button type="button" data-loading-text="Loading..." class="loading-example-btn btn btn-sm btn-default">
												<a href="{{ URL::route('panel.admin.user_manage') }}" class="name">
													{{ Lang::get('dashboard.see_more_action') }}
												</a>
											</button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ Lang::get('dashboard.pending_topup_section') }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 320px;">
						<div class="scroll-content">
							<ul class="mini-timeline">
								@foreach($pending_topup_list as $topup)
								<li class="mini-timeline-lime">
									<div class="timeline-icon"></div>
									<div class="timeline-body">
										<div class="timeline-content">
											<a href="{{ url('/panel/admin/transaction/verify/' . $topup->transaction_id) }}" class="name">{{ $topup->user_name }} - {{ $topup->amount}}</a>
											<span class="time">{{ $topup->transaction_date }}</span>
										</div>
									</div>
								</li>
								@endforeach
								<li class="mini-timeline-default">
									<div class="timeline-body ml-n">
										<div class="timeline-content">
											<button type="button" data-loading-text="Loading..." class="loading-example-btn btn btn-sm btn-default">
												<a href="{{ URL::route('panel.admin.transaction_manage') }}" class="name">
													{{ Lang::get('dashboard.see_more_action') }}
												</a>
											</button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ Lang::get('dashboard.pending_withdraw_section') }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 320px;">
						<div class="scroll-content">
							<ul class="mini-timeline">
								@foreach($pending_withdraw_list as $withdraw)
								<li class="mini-timeline-lime">
									<div class="timeline-icon"></div>
									<div class="timeline-body">
										<div class="timeline-content">
											<a href="{{ url('/panel/admin/transaction/verify/' . $withdraw->transaction_id) }}" class="name">{{ $withdraw->user_name }} - {{ $withdraw->amount }}</a>
											<span class="time">{{ $withdraw->transaction_date }}</span>
										</div>
									</div>
								</li>
								@endforeach
								<li class="mini-timeline-default">
									<div class="timeline-body ml-n">
										<div class="timeline-content">
											<button type="button" data-loading-text="Loading..." class="loading-example-btn btn btn-sm btn-default">
												<a href="{{ URL::route('panel.admin.transaction_manage') }}" class="name">
													{{ Lang::get('dashboard.see_more_action') }}
												</a>
											</button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		@endif

	@if((bool)Auth::user()->is_admin)
	<div class="row">
		<div class="col-md-3">
			<div class="info-tile tile-orange">
				<div class="tile-icon"><i class="ti ti-shopping-cart-full"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.daily_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $daily_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-success">
				<div class="tile-icon"><i class="ti ti-bar-chart"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.weekly_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $weekly_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">12.7% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-info">
				<div class="tile-icon"><i class="ti ti-stats-up"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.monthly_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $monthly_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">5.2% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="ti ti-bar-chart-alt"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.yearly_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $yearly_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">10.5% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="info-tile tile-orange">
				<div class="tile-icon"><i class="ti ti-shopping-cart-full"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.daily_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $daily_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-success">
				<div class="tile-icon"><i class="ti ti-bar-chart"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.weekly_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $weekly_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">12.7% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-info">
				<div class="tile-icon"><i class="ti ti-stats-up"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.monthly_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $monthly_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">5.2% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="ti ti-bar-chart-alt"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.yearly_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $yearly_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">10.5% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
	</div>
	@endif

	<div data-widget-group="group1">
		<div class="row">
			@if(!(bool)Auth::user()->is_admin)
			<div class="col-md-12">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ Lang::get('dashboard.casino_section') }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 600px;">
						<div class="scroll-content">
							<ul>
							
		
								<li>
									<button type="button" onclick="alert('Hello world!')">Click Me!</button>
								</li><br>
								<li>
									<button type="button" onclick="alert('Hello world!')">Topup</button>
								</li><br>
								<li>
									<button type="button" onclick="alert('Hello world!')">Tranfer</button>
								</li><br>
								<li>
									<button type="button" onclick="alert('Hello world!')">Withdraw</button>
								</li><br>
								<li>
									<button type="button" onclick="alert('Hello world!')">News & Promotion</button>
								</li><br>
								<li>
									<button type="button" onclick="alert('Hello world!')">Gam Link</button>
								</li><br>
								<li>
									<button type="button" onclick="alert('Hello world!')">Click Me!</button>
								</li><br>

							</ul>
						</div>
					</div>
				</div>
			</div>
			@endif
			
			@if((bool)Auth::user()->is_admin)
			<div class="col-md-6">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ Lang::get('dashboard.recent_users_section') }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 320px;">
						<div class="scroll-content">
							<ul class="mini-timeline">
								@foreach($new_user_list as $new_user)
								<li class="mini-timeline-lime">
									<div class="timeline-icon"></div>
									<div class="timeline-body">
										<div class="timeline-content">
											<a href="{{ url('/panel/admin/user/edit/' . $new_user->user_id) }}" class="name">{{ $new_user->name }}</a>
											<span class="time">{{ $new_user->created_at }}</span>
										</div>
									</div>
								</li>
								@endforeach
								<li class="mini-timeline-default">
									<div class="timeline-body ml-n">
										<div class="timeline-content">
											<button type="button" data-loading-text="Loading..." class="loading-example-btn btn btn-sm btn-default">
												<a href="{{ URL::route('panel.admin.user_manage') }}" class="name">
													{{ Lang::get('dashboard.see_more_action') }}
												</a>
											</button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div> 
			@else
			<div class="col-md-6">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ Lang::get('company.company_bank_info_grid') }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 320px;">
						<div class="scroll-content">
							<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>{{ Lang::get('general.grid_no') }}</th>
										<th>{{ Lang::get('bank.bank_name_field') }}</th>
										<th>{{ Lang::get('company.bank_account_field') }}</th>
										<th>{{ Lang::get('company.bank_fullname_field') }}</th>
									</tr>
								</thead>
								<tbody>
								<?php $i=1; ?>
								@foreach($company_bank_list as $company_bank)
									<tr> 
										<td>{{$i}}</td>
										<td>{{$company_bank->bank_name}}</td>
										<td>{{$company_bank->bank_account}}</td>
										<td>{{$company_bank->bank_fullname}}</td>
									</tr>
								<?php $i++; ?>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			@endif
			<div class="col-md-12">
				<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                	<h2>{{ Lang::get('dashboard.recent_news_section') }}</h2>
					</div>
					<div class="panel-body scroll-pane" style="height: 320px;">
						<div class="scroll-content">
							<ul class="mini-timeline">
								@foreach($new_news_list as $new_news)
								<li class="mini-timeline-lime">
									<div class="timeline-icon"></div>
									<div class="timeline-body">
										<div class="timeline-content">
											<a href="{{ url('/panel/news/view/' . $new_news->news_id) }}" class="name">{{ $new_news->title }}</a>
											<span class="time">{{ $new_news->updated_at }}</span>
										</div>
									</div>
								</li>
								@endforeach()
								<li class="mini-timeline-default">
									<div class="timeline-body ml-n">
										<div class="timeline-content">
											<button type="button" data-loading-text="Loading..." class="loading-example-btn btn btn-sm btn-default">
												<a href="{{ URL::route('user.news_manage') }}" class="name">
													{{ Lang::get('dashboard.see_more_action') }}
												</a>
											</button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	@if(!(bool)Auth::user()->is_admin)
	<div class="row">
		<div class="col-md-3">
			<div class="info-tile tile-orange">
				<div class="tile-icon"><i class="ti ti-shopping-cart-full"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.daily_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $daily_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-success">
				<div class="tile-icon"><i class="ti ti-bar-chart"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.weekly_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $weekly_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">12.7% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-info">
				<div class="tile-icon"><i class="ti ti-stats-up"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.monthly_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $monthly_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">5.2% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="ti ti-bar-chart-alt"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.yearly_topup_field') }}</span></div>
				<div class="tile-body"><span>{{ $yearly_topup_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">10.5% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="info-tile tile-orange">
				<div class="tile-icon"><i class="ti ti-shopping-cart-full"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.daily_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $daily_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-success">
				<div class="tile-icon"><i class="ti ti-bar-chart"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.weekly_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $weekly_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">12.7% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-info">
				<div class="tile-icon"><i class="ti ti-stats-up"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.monthly_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $monthly_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-success">5.2% <i class="fa fa-level-up"></i></span></div>-->
			</div>
		</div>
		<div class="col-md-3">
			<div class="info-tile tile-danger">
				<div class="tile-icon"><i class="ti ti-bar-chart-alt"></i></div>
				<div class="tile-heading"><span>{{ Lang::get('dashboard.yearly_withdraw_field') }}</span></div>
				<div class="tile-body"><span>{{ $yearly_withdraw_amount }}</span></div>
				<!--<div class="tile-footer"><span class="text-danger">10.5% <i class="fa fa-level-down"></i></span></div>-->
			</div>
		</div>
	</div>
	@endif

</div> <!-- .container-fluid -->
@endsection

@section('sitescript')
	<!-- Charts -->
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.pie.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.stack.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.orderBars.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.resize.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.tooltip.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/charts-flot/jquery.flot.spline.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/sparklines/jquery.sparklines.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/switchery/switchery.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/easypiechart/jquery.easypiechart.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/fullcalendar/moment.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
	<!--script src="{{ URL::to('/') }}/assets/demo/demo-index.js"></script-->
@endsection