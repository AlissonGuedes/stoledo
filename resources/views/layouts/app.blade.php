<!DOCTYPE html>

<html>

	<head>

		<title>@yield('title')</title>

	</head>

	<body>

		@section('header')
		@show

		@section('container')
			@yield('content')
		@show

	</body>

</html>