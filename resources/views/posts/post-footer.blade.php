<div class="post-footer">

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
	<div class="ui tiny left pointing dropdown icon button" title="Share this Post">
		<i class="fa fa-share-alt"></i>

		<div class="menu">
			<a class="item" href="#" title="Share on Facebook">
				<i class="fa fa-facebook"></i>
			</a>
			<a class="item share-twitter" href="#" data-id="{{ $post['id'] }}" title="Tweet this Post">
				<i class="fa fa-twitter"></i>
			</a>
			<a class="item share-google" href="#" data-id="{{ $post['id'] }}" title="Share on Google+">
				<i class="fa fa-google-plus"></i>
			</a>
			<a class="item" href="#" title="Pin this">
				<i class="fa fa-pinterest"></i>
			</a>
			<a class="item" href="#" title="Send in email">
				<i class="fa fa-envelope"></i>
			</a>
		</div>
	</div>

	{{-- comments --}}
	@if ($viewName !== 'single')
		<button class="ui tiny icon button pull-right" title="View comments">
			<i class="fa fa-comment"></i>
			<span itemprop="commentCount">{{ $post['num_comments'] }}</span>
		</button>
	@endif

	{{-- reddit --}}
	<a class="ui tiny icon button pull-right" href="http://www.reddit.com{{ $post['permalink'] }}" target="_blank" title="Go to Reddit" itemprop="sameAs">
		<i class="fa fa-reddit"></i>
	</a>

</div>
