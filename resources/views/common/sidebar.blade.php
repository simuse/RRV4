<aside class="sidebar sidebar-left" id="sidebar-main">

	{{-- sidebar-form --}}
	<form action="/" method="post" class="sidebar-form">
		<div class="input-group">

			<input type="text" name="subreddit" class="form-control" placeholder="Enter subreddit" autofocus="autofocus">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default">Go</button>
			</span>

		</div>
	</form>{{-- / sidebar-form --}}

	{{-- sidebar-nav --}}
	<ul class="nav sidebar-nav">
		<li>
			<a href="#menu-account" data-toggle="collapse" class="collapsed"><i class="fa fa-user"></i> Account<span class="caret"></span></a>
			<ul class="collapse nav sidebar-subnav" id="menu-account">
				<li><a href="#">Login</a></li>
			</ul>
		</li>
		<li>
			<a href="#menu-suggestions" data-toggle="collapse" class="collapsed"><i class="fa fa-diamond"></i> Suggestions<span class="caret"></a>
			<ul class="collapse nav sidebar-subnav" id="menu-suggestions">
				@foreach(Config::get('reddit.suggested') as $key => $value)
					<li><a href="/r/{{ $value }}">{{ $value }}</a></li>
				@endforeach
			</ul>
		</li>
		<li><a href="#" data-toggle="modal" data-target="#modal-settings"><i class="fa fa-cog"></i> Settings</a></li>
		<li><a href="#"><i class="fa fa-info-circle"></i> About</a></li>
	</ul>{{-- / sidebar-nav --}}

</aside>
