
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown toolbar-icon-bg">
						<div class="btn-group">
					         @foreach(config('app.locales') as $lang => $lang_name)
					         	<a href="{{ url('/language?lang=').$lang }}" >
					         		<img src="{{ url('/') . '/images/logo/language/' . $lang_name . '_flag.png' }}" height="30" width="30" alt="{{ $lang_name }}">
					            </a>
					        @endforeach
					    </div>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-left">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">{{ Lang::get('general.login') }}</a></li>
						<li><a href="{{ url('/auth/register') }}">{{ Lang::get('general.register') }}</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">{{ Lang::get('general.logout') }}</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
