<!DOCTYPE html>
<html lang="en">
<head>
	@include('common.head')
</head>
<body>

	@yield('header')

	<div class="wrap" role="document">

		@yield('content')

	</div>

	@include('common.scripts')
</body>
</html>
