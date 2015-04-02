<div class="post-heading">

	<a class="ui corner label">
		<i class="fa fa-image"></i>
	</a>

	<div class="header">
		<a class="post-title" href="/p/{{ $post['id'] }}">{{ $post['title'] }}</a>
		{{-- <i class="post-type fa fa-image pull-right"></i> --}}
	</div>

	<hr>

	<div class="meta">

		<p class="pull-left">
			<a class="post-subreddit" href="/r/{{ $post['subreddit'] }}">
				<strong>{{ $post['subreddit'] }}</strong>
			</a>
			- <span class="post-score ui tiny red label">{{ $post['score'] }}</span>
			- <span class="post-time">submitted {{ $post['timeago'] }} ago by</span>
			<a class="post-author" href="#">{{ $post['author'] }}</a>
		</p>

		<p class="post-domain pull-right">{{ $post['domain'] }}</p>

	</div>

</div><!-- / panel-heading -->
