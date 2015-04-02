<div class="panel-heading">

	<i class="post-type fa fa-image"></i>

	<div class="row">
		<div class="col-sm-12">
			<a class="post-title" href="/p/{{ $post['id'] }}">{{ $post['title'] }}</a>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<hr>
			<div class="post-meta">

				<p class="pull-left">
					<a class="post-subreddit" href="/r/{{ $post['subreddit'] }}"><strong>{{ $post['subreddit'] }}</strong></a>
					- <span class="badge post-score">{{ $post['score'] }}</span>
					- <span class="post-time">submitted {{ $post['timeago'] }} ago by</span>
					<a class="post-author" href="#">{{ $post['author'] }}</a>
				</p>

				<p class="post-domain">{{ $post['domain'] }}</p>

			</div>
		</div>
	</div>

</div><!-- / panel-heading -->

