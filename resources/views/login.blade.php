@extends('layouts.user')

@section('content')

<div class="container">

	<div class="well col-md-6 col-md-offset-3">
	
		<form method="post">

			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" name="username" id="username" placeholder="Your Reddit username">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" id="password" placeholder="Password">
			</div>

			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Remember me
				</label>
			</div>

			<button type="submit" class="btn btn-primary">Login</button>

		</form>
		
	</div>
	
</div>


@endsection
