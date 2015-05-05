{{-- menu --}}
<header class="main-header">

	@include('common.loader')

	<div class="ui large inverted primary menu" id="menu-primary">

		{{-- sidebar toggle --}}
		<button class="item ui primary button" id="sidebar-toggle" type="button" title="Toggle sidebar">
			<i class="fa fa-bars"></i>
		</button>

		{{-- header --}}
		<a class="header item" href="{{ url('/') }}" title="The Front Page">
			Red.It
	  	</a>

		<div class="right menu">

			{{-- form --}}
			<div class="item item-form">
				{!! Form::open(array(
					'action' => 'HomeController@formToSubreddit',
					'class'  => 'form-header'
				))!!}
				<div class="ui transparent input">
					{!! Form::text('subreddit', null, array(
						'id' 		  => 'input-subreddit',
						'placeholder' => 'Enter Subreddit'
					))!!}
				</div>
				<button class="item ui icon button" type="submit" title="Submit">
					<i class="fa fa-search"></i>
				</button>
				{!! Form::close()!!}
			</div>

			{{-- user --}}
			@if ($user)
				<div class="ui dropdown item" id="menu-user">
					{{ $user['name'] }}
					<i class="dropdown icon"></i>
					<div class="menu">
						<a class="item" href="{{ url('/me') }}">My account</a>
						<div class="divider"></div>
						<a class="item" href="{{ url('/logout') }}">Logout</a>
					</div>
				</div>
			@else
				<button class="item ui vertical animated secondary button" id="toggle-modal-login" title="Login with Reddit">
					<div class="hidden content">Login</div>
					<div class="visible content">
						<i class="fa fa-user"></i>
					</div>
				</button>
			@endif

			{{-- arrow navigation --}}
			@if ($viewName === 'index')
				<a class="item ui icon button @if($page <= 1) disabled @endif" href="@if($page <= 1) # @else ?p={{ $page - 1 }}@endif" title="Previous page">
					<i class="fa fa-arrow-left"></i>
				</a>
				<a class="item ui icon button" href="?p={{ $page + 1 }}" title="Next page">
					<i class="fa fa-arrow-right"></i>
				</a>
			@endif

		</div>

	</div>

	@if ($viewName === 'index')
		<div class="ui menu pull-right" id="menu-secondary">

			{{-- sort --}}
			<div class="ui dropdown item">
				{{ $sort ? ucfirst($sort) : 'Sort' }}
				{{ $sortSince ? ' : ' . ucfirst($sortSince) : '' }}
				<i class="fa fa-sort"></i>

				<div class="ui vertical menu">
					@foreach (Config::get('reddit.defaults.sortBy') as $key => $value)

						@if (in_array($value, array('top', 'controversial')))
							<div class="ui dropdown item">
								<i class="fa fa-caret-left"></i>
								{{ ucfirst($value) }}

								<div class="menu">
									@foreach (Config::get('reddit.defaults.sortSince') as $k => $v)
										<a class="item @if ($v === $sort) active @endif" href="{{ $url }}/{{ $value }}/{{ $v }}">
											{{ ucfirst($v) }}
										</a>
									@endforeach
								</div>

							</div>
						@else
							<a class="item @if ($value === $sort) active @endif" href="{{ $url }}/{{ $value }}">
								{{ ucfirst($value) }}
							</a>
						@endif

					@endforeach
				</div>

			</div>

			{{-- toggleLayout --}}
			<div class="item ui tiny icon buttons">
					<button class="ui active button set-layout" data-layout="list" title="Set layout as List">
						<i class="fa fa-list"></i>
					</button>
					<button class="ui button set-layout" data-layout="grid" title="Set layout as Grid">
						<i class="fa fa-th"></i>
					</button>

				{{-- <div class="ui vertical animated primary button" id="toggle-layout" title="Toggle layout">
					<div class="hidden content">Layout</div>
					<div class="visible content">
						<i class="fa fa-th"></i>
					</div>
				</div> --}}
			</div>

		</div>
	@endif

</header>


















