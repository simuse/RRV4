<div class="ui small modal">

	<div class="header">
		Login with Reddit
	</div>

	<div class="content">

		<div class="ui warning form">

			{{-- alert --}}
			@if (1 === 0)
				<div class="ui warning message">
					<div class="header">Could you check something!</div>
					<ul class="list">
						<li>You forgot your <b>Username</b></li>
						<li>And also your <b>Password</b></li>
					</ul>
				</div>
			@endif

			<form action="/auth" method="POST">

				<div class="ui segment">
					<p>You will be redirected to Reddit.com to authenticate.</p>
				</div>

				<button class="ui right labeled icon primary button" type="submit">
					<i class="icon fa fa-reddit"></i>
					Login
				</button>

			</form>

		</div>

	</div>

</div>
