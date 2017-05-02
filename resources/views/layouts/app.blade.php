<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title') | Eanstore</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="{{ url('css/app.css') }}">
	</head>
	<body>
		<div id="app">
			<nav class="navbar navbar-inverse">
				<div class="container">
					<div class="navbar-header">
						<a class="navbar-brand" href="{{ url('/') }}">
							Eanstore
						</a>
					</div>
					<form class="navbar-form navbar-left" method="POST" action="{{ action('ProductController@search') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<input placeholder="Search by barcode..." name="barcode" type="number" class="form-control" />
						</div>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<li class="dropdown">
					          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
					          	<ul class="dropdown-menu">
					          		<li><a href="{{ action('ProductController@index') }}">List</a></li>
						            <li><a href="{{ action('ProductController@create') }}">Register</a></li>
					          </ul>
					        </li>
						</li>
					</ul>
				</div>
			</nav>
			<div class="container">
				@yield('content')
			</div>
		</div>
		<script>
		    window.Laravel = {!! json_encode([
		        'csrfToken' => csrf_token(),
		    ]) !!};
		</script>
		<script src="{{ url('js/app.js') }}"></script>
	</body>
</html>