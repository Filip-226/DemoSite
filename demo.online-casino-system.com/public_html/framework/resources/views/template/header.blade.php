        <header id="topnav" class="navbar navbar-default navbar-fixed-top" role="banner">

	<div class="logo-area">
		<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
			<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
				<span class="icon-bg">
					<i class="ti ti-menu"></i>
				</span>
			</a>
		</span>
		
		<a class="navbar-brand" href="{{ URL::to('/panel') }}">{{ Lang::get('general.app_name') }}</a>

	</div><!-- logo-area -->

	<ul class="nav navbar-nav toolbar pull-right">
		<li class="dropdown toolbar-icon-bg">
			<div class="btn-group">
		         @foreach(config('app.locales') as $lang => $lang_name)
		         	<a href="{{ url('/language?lang=').$lang }}" >
		         		<img src="{{ url::to('/') . '/images/logo/language/' . $lang_name . '_flag.png' }}" height="30" width="30" alt="{{ $lang_name }}">
		            </a>
		        @endforeach
		    </div>
		</li>

		<li class="dropdown toolbar-icon-bg">
			<a href="#" class="dropdown-toggle username" data-toggle="dropdown">
				<img class="img-circle" src="http://placehold.it/300&text=Placeholder" alt="" />
			</a>
			<ul class="dropdown-menu userinfo arrow">
				<li><a href="{{ url('/auth/logout') }}"><i class="ti ti-shift-right"></i><span>{{ Lang::get('general.logout') }}</span></a></li>
			</ul>
		</li>

	</ul>

</header>