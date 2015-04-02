{{-- menu --}}
<nav class="ui large menu fixed">

	{{-- header --}}
	<a class="header item" href="#">
		Red.It
  	</a>

	<div class="right menu">

		{{-- sort --}}
		@if ($viewName === 'index')
			<div class="ui dropdown item">
				{{ $sort ? ucfirst($sort) : 'Sort' }}
				<i class="fa fa-sort"></i>
				<div class="menu">
					@foreach (Config::get('reddit.sortOptions') as $key => $value)
					<li >
						<a class="item @if ($value === $sort) active @endif" href="{{ $url }}/{{ $value }}">
							{{ ucfirst($value) }}
						</a>
					</li>
				@endforeach
				</div>
			</div>
		@endif{{-- / sort --}}

		{{-- sortFrom --}}
		@if (in_array($sort, array('top', 'controversial')) && $viewName === 'index')
			<div class="ui dropdown item">
				{{ $sortFrom ? ucfirst($sortFrom) : 'From' }}
				<i class="fa fa-clock-o"></i>
				<div class="menu">
					@foreach (Config::get('reddit.timeOptions') as $key => $value)
					<li >
						<a class="item @if ($value === $sort) active @endif" href="{{ $url }}/{{ $sort }}/{{ $value }}">
							{{ ucfirst($value) }}
						</a>
					</li>
				@endforeach
				</div>
			</div>
		@endif{{-- / sortFrom --}}

		<div class="item">
			<div class="ui primary icon button" id="toggle-layout" title="Toggle layout">
				<i class="fa fa-th"></i>
			</div>
		</div>

		<a class="item ui icon button @if($page <= 1) disabled @endif" href="@if($page <= 1) # @else ?p={{ $page - 1 }}@endif" title="Previous page">
			<i class="fa fa-arrow-left"></i>
		</a>

		<a class="item ui icon button" href="?p={{ $page + 1 }}" title="Next page">
			<i class="fa fa-arrow-right"></i>
		</a>

	</div>

	@include('common.loader')

</nav>{{-- / menu --}}
