<nav class="navbar navbar-default navbar-fixed-top">

	{{-- navbar-header --}}
	<div class="navbar-header">
		<a href="#" class="sidebar-toggle" id="sidebar-toggle">
			<i class="fa fa-bars" data-toggle="fa-times"></i>
		</a>
		<a class="navbar-brand" href="/"><h1>Red.it</h1></a>
	</div>

	{{-- navbar-right --}}
	<ul class="nav navbar-nav navbar-right">

		{{-- btn-sort --}}
		@if ($viewName === 'index')
			<li>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle navbar-btn btn-sort" data-toggle="dropdown" aria-expanded="false" title="Sort by">
						<i class="fa fa-sort"></i>
						{{ $sort ? ucfirst($sort) : 'Sort' }}
					</button>

					<ul class="dropdown-menu" role="menu">
						@foreach (Config::get('reddit.sortOptions') as $key => $value)
							<li @if ($value === $sort)class="active"@endif>
								<a href="{{ $url }}/{{ $value }}">{{ ucfirst($value) }}</a>
							</li>
						@endforeach
					</ul>
				</div>
			</li>
		@endif{{-- / btn-sort --}}

		{{-- btn-sortFrom --}}
		@if (in_array($sort, array('top', 'controversial')) && $viewName === 'index')
			<li>
				<div class="btn-group btn-">
					<button type="button" class="btn btn-default dropdown-toggle navbar-btn btn-sortFrom" data-toggle="dropdown" aria-expanded="false" title="Links from">
						<i class="fa fa-clock-o"></i>
						{{ $sortFrom ? ucfirst($sortFrom) : 'From' }}
					</button>

					<ul class="dropdown-menu" role="menu">
						@foreach (Config::get('reddit.timeOptions') as $key => $value)
							<li @if ($value === $sortFrom)class="active"@endif>
								<a href="{{ $url }}/{{ $sort }}/{{ $value }}">{{ ucfirst($value) }}</a>
							</li>
						@endforeach
					</ul>
				</div>
			</li>
		@endif{{-- / btn-sortFrom --}}

		<li>
			<a class="disabled" id="toggle-layout" href="#" title="Toggle layout">
				<i class="fa fa-th"></i>
			</a>
		</li>

		<li>
			<a class="@if($page <= 1) disabled @endif" href="@if($page <= 1) # @else ?p={{ $page - 1 }}@endif" title="Previous page">
				<i class="fa fa-arrow-left"></i>
			</a>
		</li>

		<li>
			<a href="?p={{ $page + 1 }}" title="Next page">
				<i class="fa fa-arrow-right"></i>
			</a>
		</li>

	</ul>{{-- / navbar-right --}}

	<div id="page-loader"><span class="bar"></span></div>

</nav>
