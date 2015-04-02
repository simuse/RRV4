<div class="extra content">

	{{-- votes --}}
	<div class="ui tiny icon buttons">
		<button class="ui icon button" title="Upvote">
			<i class="fa fa-arrow-up"></i>
		</button>
		<button class="ui icon button" title="Downvote">
			<i class="fa fa-arrow-down"></i>
		</button>
	</div>

	{{-- favorite --}}
	<button class="ui tiny icon button" title="Add to favorites">
		<i class="fa fa-star"></i>
	</button>

	{{-- share --}}
	<div class="ui tiny left pointing dropdown icon button">
		<i class="fa fa-share"></i>

		<div class="menu">
			<a class="item" href="#" title="Share on Facebook">
				<i class="fa fa-facebook"></i>
			</a>
			<a class="item" href="#" title="Tweet this post">
				<i class="fa fa-twitter"></i>
			</a>
			<a class="item" href="#" title="Share on Google+">
				<i class="fa fa-google-plus"></i>
			</a>
			<a class="item" href="#" title="Pin on Pinterest">
				<i class="fa fa-pinterest"></i>
			</a>
			<a class="item" href="#" title="Share via email">
				<i class="fa fa-envelope"></i>
			</a>
		</div>
	</div>

	{{-- comments --}}
	@if ($viewName !== 'single')
		<button class="ui tiny icon button pull-right" title="View comments">
			<i class="fa fa-comment"></i>
			{{ $post['num_comments'] }}
		</button>
	@endif

	{{-- reddit --}}
	<a class="ui tiny icon button pull-right" href="http://www.reddit.com{{ $post['permalink'] }}" target="_blank" title="View on Reddit">
		<i class="fa fa-reddit"></i>
	</a>

</div>
