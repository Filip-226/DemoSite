<!DOCTYPE html>
<html lang="en" ng-app="tp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="base_url" content="{{ URL::to('/') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ Lang::get('general.app_name') }}</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link type='text/css' href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600' rel='stylesheet'>

    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/fonts/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/fonts/themify-icons/themify-icons.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/css/styles.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/plugins/codeprettifier/prettify.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/plugins/iCheck/skins/minimal/blue.css"/>

    <!-- The following CSS are included as plugins and can be removed if unused-->
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/plugins/fullcalendar/fullcalendar.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/assets/plugins/switchery/switchery.css"/>

    <script src="{{ URL::to('/') }}/lib/angular/angular.min.js"></script>
    <script src="{{ URL::to('/') }}/lib/angular/ui-bootstrap-tpls-0.11.0.min.js"></script>
    <script src="{{ URL::to('/') }}/lib/angular/angular-cookie.min.js"></script>
    <script src="{{ URL::to('/') }}/lib/angular/angular-sanitize.min.js"></script>
    <script src="{{ URL::to('/') }}/lib/angular/angular-animate.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!--FOR ANGULARJS UPLOAD-->
    <script type="text/javascript">
    FileAPI = {
        debug: true,
        //forceLoad: true, html5: false //to debug flash in HTML5 browsers
        //wrapInsideDiv: true, //experimental for fixing css issues
        //only one of jsPath or jsUrl.
        //jsPath: '/js/FileAPI.min.js/folder/', 
        //jsUrl: 'yourcdn.com/js/FileAPI.min.js',

        //only one of staticPath or flashUrl.
        //staticPath: '/flash/FileAPI.flash.swf/folder/'
        //flashUrl: 'yourcdn.com/js/FileAPI.flash.swf'
    };
    </script>

    <script src="{{ URL::to('/') }}/js/app/app.js"></script>

    <link rel="stylesheet" href="{{ URL::to('/') }}/css/animate.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/aside.css"/>

    <script src="{{ URL::to('/') }}/lib/angular/aside/app.js"></script>
    <script src="{{ URL::to('/') }}/lib/angular/aside/services/aside.js"></script>

    <script src="{{ URL::to('/') }}/assets/js/jquery-1.10.2.min.js"></script>

    @yield('sitestyle')
</head>
<body class="{{ $fullscreen == '1'?'focused-form':'' }} animated-content">
		
		@yield('header')

        <div id="wrapper">
            <div id="layout-static">

				@yield('sidebar')

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
							@yield('content')

                        </div> <!-- #page-content -->
                    </div>
                    <footer role="contentinfo">
						<div class="clearfix">
							<ul class="list-unstyled list-inline pull-left">
								<li><h6 style="margin: 0;">© {{ Lang::get('general.app_name') }}. {{ date('Y') }}</h6></li>
							</ul>
							<button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
						</div>
					</footer>
                </div>
            </div>
        </div>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ URL::to('/') }}/assets/js/jqueryui-1.10.3.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/validator.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/enquire.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/velocityjs/velocity.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/velocityjs/velocity.ui.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/wijets/wijets.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/codeprettifier/prettify.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/iCheck/icheck.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/application.js"></script>
    <script src="{{ URL::to('/') }}/assets/demo/demo.js"></script>
    <script src="{{ URL::to('/') }}/assets/demo/demo-switcher.js"></script>
	
	@if(Auth::check() && Auth::user()->is_admin)
    <script src="{{ URL::to('/') }}/assets/js/jquery.playSound.js"></script>
	<script>

	window.setInterval(function(){
	/// call your function here
			$.ajax({
				url: '{{ URL::route('panel.admin.notification') }}',
				type: 'get',
				//dataType: 'json',
				data: {
					"_token": $('meta[name="csrf-token"]').attr('content'),
				},
				cache: false,
				contentType: false,
				processData: false,

				success: function(json) {
					if(json.result) {
						$.playSound('{{ URL::to('/') }}/dist/sounds');
					}
				}
			});
	}, 10000);
	</script>
	@endif
	@yield('sitescript')
</body>
</html>
