<!DOCTYPE html>
<html>
	<head>
		<!-- Site title -->
		<title>Paypal Express Checkout</title>

		<link href="{{ URL::to_asset('bundles/pec/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ URL::to_asset('bundles/pec/css/style.css') }}" rel="stylesheet">
		<style type="text/css">body { padding-top: 60px; }</style>
	</head>
	<body>
		<!-- html > body > .navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="{{ URL::to('pec') }}">Paypal Express Checkout</a>
					<div class="nav-collapse collapse">                                            
                                            
					</div>
				</div>
			</div>
		</div>

		<!-- html > body > .container -->
		<div class="container">
			@if ($success = Session::get('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> {{ $success }}
				</div>
			@endif
			@if ($error = Session::get('error'))
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>Error!</strong> {{ $error }}
				</div>
			@endif
			@if ($warning = Session::get('warning'))
			<div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Warning!</strong> {{ $warning }}
			</div>
			@endif

			<!-- Content -->
			@yield('content')
		</div>
<script type="text/javascript">
var BASE = "<?php echo URL::base(); ?>/pec"
var BASEstore = "<?php echo URL::to_action('pec::store');  ?>"
</script>
		<!-- Scripts -->
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="{{ URL::to_asset('bundles/pec/js/bootstrap.js') }}"></script>
		@yield('scripts')
	</body>
</html>
