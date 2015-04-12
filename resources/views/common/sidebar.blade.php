<div class="ui left vertical inverted sidebar menu" id="sidebar">

	{{-- subscriptions --}}
	@if (!empty($mySubscriptions))
		<div class="item">
			Subscriptions
			<div class="menu">
				@foreach($subscriptions as $key => $value)
					<a class="item" href="/r/{{ $value['data']['display_name'] }}">{{ $value['data']['display_name'] }}</a>
				@endforeach
			</div>
		</div>
	@endif

	{{-- multis --}}
	@if (!empty($myMultis))
		<div class="item">
			Multis
			<div class="menu">
				@foreach($myMultis as $key => $value)
					<?php
						$multisUrl = $value['data']['subreddits'];
						// dd($multisUrl);
					 ?>
					<a class="item" href="/r/@foreach($value['data']['subreddits'] as $k => $v){{ $v['name'] }}+@endforeach">{{ $value['data']['name'] }}</a>
				@endforeach
			</div>
		</div>
	@endif

	{{-- suggested --}}
	<div class="item">
		Suggested
		<div class="menu">
			@foreach(Config::get('reddit.defaults.suggested') as $key => $value)
				<a class="item" href="/r/{{ $value }}">{{ $value }}</a>
			@endforeach
		</div>
	</div>

	<a class="item" href="#">
		About
	</a>

</div>
