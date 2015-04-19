{{--
missing/implicit information
canonical references
 --}}

<?php

$icon = 'image';

if ($post['type'] === 'video') {
	$icon = 'video-camera';
} else if ($post['type'] === 'reddit') {
	$icon = 'reddit';
} else if ($post['type'] === 'text') {
	$icon = 'text';
}

?>

<div class="post-heading">

	<div class="header">
		<a class="post-title" href="/p/{{ $post['id'] }}" itemprop="name url headline discussionUrl">
			{{ $post['title'] }}
		</a>
		<i class="post-type fa fa-{{ $icon }} pull-right" title="post-type"></i>
	</div>

	<div class="meta">

		<hr>

		<p class="pull-left">
			<a class="post-subreddit" href="/r/{{ $post['subreddit'] }}" itemprop="about">
				<strong>{{ $post['subreddit'] }}</strong>
			</a>
			<span class="post-score ui tiny red label" itemprop="aggregateRating">{{ $post['score'] }}</span>
			<span class="post-time">submitted
				<time datetime="{{ date('Y-m-d', time($post['created'])) }}" itemprop="datePublished uploadDate">
					{{ $post['timeago'] }}
				</time> ago by
			</span>
			<a class="post-author" href="/u/{{ $post['author'] }}" itemprop="author">{{ $post['author'] }}</a>
		</p>

		<p class="post-domain pull-right">{{ $post['domain'] }}</p>

	</div>

</div>
