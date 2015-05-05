<div class="post-footer">

	<div class="ui small secondary pointing menu">

		{{-- comments --}}
		@if ($viewName !== 'single')
			<a class="item" href="/p/{{ $post['id'] }}" title="View comments">
				<i class="fa fa-comment"></i>
				<span itemprop="commentCount">{{ $post['num_comments'] }}</span>
			</a>
		@endif

		<div class="right menu">

			{{-- votes --}}
			<a class="ui item @if (!$user)toggle-popup" data-content="You need to be logged in to Upvote @endif">
				<i class="fa fa-arrow-up"></i>
			</a>
			<a class="ui item @if (!$user)toggle-popup" data-content="You need to be logged in to Downvote @endif">
				<i class="fa fa-arrow-down"></i>
			</a>

			{{-- favorite --}}
			<a class="ui item @if (!$user)toggle-popup" data-content="You need to be logged in to add to Favorites @endif">
				<i class="fa fa-star"></i>
			</a>

			{{-- share --}}
			<div class="ui right pointing dropdown item" title="Share this Post">
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

		</div>

	</div>

</div>
