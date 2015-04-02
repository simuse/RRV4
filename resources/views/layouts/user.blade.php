<!DOCTYPE html>
<html lang="en">
<head>
	@include('common.head')
</head>
<body>
	@include('common.sidebar')

	@include('common.header-user')

	<div class="wrap" role="document">

		@yield('content')
		
	</div>

	@include('common.modal-settings')

	@include('common.scripts')
</body>
</html>
