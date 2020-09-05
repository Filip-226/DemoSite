				<div class="static-sidebar-wrapper sidebar-midnightblue">
					<div class="static-sidebar">
						<div class="sidebar">
							<div class="widget">
								<div class="widget-body">
									<div class="userinfo">
										<div class="">
											<span class="username">{{ Auth::user()->name }}</span>
											<br>
											<span class="useremail">{{ Auth::user()->email }}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="widget stay-on-collapse" id="widget-sidebar">
								<nav role="navigation" class="widget-body">
									<ul class="acc-menu">
										<!-- Dashboard area -->
										<li class="nav-separator"><span>{{ Lang::get('general.explore_section') }}</span></li>
										<li><a href="{{ URL::route('user.dashboard') }}"><i class="ti ti-home"></i><span>{{ Lang::get('general.dashboard_page') }}</span></a></li>

										<!-- Member management area -->
										<li class="nav-separator"><span>{{ Lang::get('general.member_management_section') }}</span></li>
										<li><a href="javascript:;"><i class="fa fa-user"></i><span>{{ Lang::get('general.member_profile_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('user.login_details') }}">{{ Lang::get('general.member_logindetails_page') }}</a></li>
											</ul>
										</li>
										<li><a href="{{ URL::route('user.transaction_add') }}?action=topup"><i class="ti ti-money"></i><span>{{ Lang::get('general.transaction_topup') }}</span></a></li>
										<li><a href="{{ URL::route('user.transaction_add') }}?action=withdraw"><i class="ti ti-money"></i><span>{{ Lang::get('general.transaction_withdraw') }}</span></a></li>
										<li><a href="{{ URL::route('user.transfer_add') }}"><i class="ti ti-money"></i><span>{{ Lang::get('general.transfer') }}</span></a></li>
										<li><a href="javascript:;"><i class="fa fa-edit"></i><span>{{ Lang::get('general.transaction_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('user.transaction_manage') }}">{{ Lang::get('general.transaction_manage_page') }}</a></li>
												<li><a href="{{ URL::route('user.transfer_manage') }}">{{ Lang::get('general.transfer_manage_page') }}</a></li>
												<li><a href="{{ URL::route('user.history_manage') }}">{{ Lang::get('general.transaction_view_verifiedtransaction_page') }}</a></li>
											</ul>
										</li>
										<li><a href="javascript:;"><i class="fa fa-newspaper-o"></i><span>{{ Lang::get('general.news_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('user.news_manage') }}">{{ Lang::get('general.news_view_page') }}</a></li>
											</ul>
										</li>
										<li><a href="{{ URL::route('user.inbox_manage') }}"><i class="ti ti-email"></i><span>{{ Lang::get('general.inbox_page') }}</span></a></li>
										@if(Auth::user()->is_admin)
										<!-- Admin management area -->
										<li class="nav-separator"><span>{{ Lang::get('general.admin_management_section') }}</span></li>
										<li><a href="javascript:;"><i class="fa fa-users"></i><span>{{ Lang::get('general.user_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('panel.admin.user_add') }}">{{ Lang::get('general.user_add_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.user_manage') }}">{{ Lang::get('general.user_manage_page') }}</a></li>
											</ul>
										</li>
										<li><a href="javascript:;"><i class="fa fa-newspaper-o"></i><span>{{ Lang::get('general.news_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('panel.admin.news_add') }}">{{ Lang::get('general.news_add_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.news_manage') }}">{{ Lang::get('general.news_manage_page') }}</a></li>
											</ul>
										</li>
										<li><a href="javascript:;"><i class="fa fa-bank"></i><span>{{ Lang::get('general.bank_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('panel.admin.bank_add') }}">{{ Lang::get('general.bank_add_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.bank_manage') }}">{{ Lang::get('general.bank_manage_page') }}</a></li>
											</ul>
										</li>
										<li><a href="javascript:;"><i class="fa fa-bell"></i><span>{{ Lang::get('general.casino_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('panel.admin.casino_add') }}">{{ Lang::get('general.casino_add_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.casino_manage') }}">{{ Lang::get('general.casino_manage_page') }}</a></li>
											</ul>
										</li>
										<li><a href="javascript:;"><i class="fa fa-briefcase"></i><span>{{ Lang::get('general.company_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('panel.admin.company_add') }}">{{ Lang::get('general.company_bankinfo_add_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.company_manage') }}">{{ Lang::get('general.company_bankinfo_manage_page') }}</a></li>
											</ul>
										</li>
										<li><a href="{{ URL::route('panel.admin.transaction_add') }}?action=topup"><i class="ti ti-money"></i><span>{{ Lang::get('general.transaction_topup') }}</span></a></li>
										<li><a href="{{ URL::route('panel.admin.transaction_add') }}?action=withdraw"><i class="ti ti-money"></i><span>{{ Lang::get('general.transaction_withdraw') }}</span></a></li>
										<li><a href="javascript:;"><i class="fa fa-check-square"></i><span>{{ Lang::get('general.transaction_page') }}</span></a>
											<ul class="acc-menu">
												<li><a href="{{ URL::route('panel.admin.transaction_manage') }}">{{ Lang::get('general.transaction_pending_verify_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.history_manage') }}">{{ Lang::get('general.transaction_history_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.transfer_manage') }}">{{ Lang::get('general.transfer_pending_verify_page') }}</a></li>
												<li><a href="{{ URL::route('panel.admin.transfer_history_manage') }}">{{ Lang::get('general.transfer_history_page') }}</a></li>
											</ul>
										</li>
										<li><a href="{{ URL::route('panel.admin.backup') }}"><i class="ti ti-save"></i><span>{{ Lang::get('general.backup_page') }}</span></a></li>
										<li><a href="{{ URL::route('panel.admin.restore') }}"><i class="ti ti-save"></i><span>{{ Lang::get('general.restore_page') }}</span></a></li>
										@endif
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>