{{-- comment menu --}}
<div class="ui small menu fluid">

	{{-- filters --}}
	@foreach (Config::get('reddit.defaults.sortComments') as $key => $value)
		<a class="item @if($data['sort'] === $value) active blue @elseif(($key === 0) && !$data['sort']) active @endif"
			href="{{ $url . '/' . $value }}">
			{{ ucfirst($value) }}
		</a>
	@endforeach

	{{-- iama mode --}}
	@if (isset($subreddit) && $subreddit === 'IAmA')
		<a class="item @if($data['sort'] === 'qa') active blue @endif"
			href="{{ $url . '/qa' }}">
			IAmA mode
		</a>
	@endif

	{{-- write comment --}}
	<div class="ui right blue inverted menu">
		<a class="item">
			<i class="fa fa-edit"></i>
			Write comment
		</a>
	</div>

</div>
