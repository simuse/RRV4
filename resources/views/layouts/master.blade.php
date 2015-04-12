<!DOCTYPE html>
<html lang="en">
<head>
	@include('common.head')
</head>
<body class="{{ 'view-' . $viewName }} pushable">

	@include('common.header')

	@include('common.sidebar')

	<div class="wrap pusher" role="document">

		<main class="main" role="main">
			@include('common.notifications')

			@yield('content')

		</main>

	</div>

	@include('modals.login')

	@include('common.scripts')

</body>
</html>
