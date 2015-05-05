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
} else if ($post['type'] === 'oembed') {
	$icon = 'newspaper-o';
}

?>

<div class="post-heading" data-variation="basic"
		data-html="<p><a class='post-subreddit' href='/r/{{ $post['subreddit'] }}'>{{ $post['subreddit'] }}</a> - {{ $post['timeago'] }} ago by <a href='/u/{{ $post['author'] }}'>{{ $post['author'] }}</a></p>">

	{{-- header --}}
	<div class="header">

		<p class="ui tiny label">{{ $post['score'] }}</p>
		@if ($viewName === 'single')
			<p class="post-title" itemprop="name headline">{{ $post['title'] }}</a>
		@else
			<a class="post-title" href="/p/{{ $post['id'] }}" itemprop="name url headline discussionUrl">{{ $post['title'] }}</a>
		@endif
		<i class="post-type fa fa-{{ $icon }} pull-right" title="post-type"></i>

	</div>

	{{-- meta --}}
	<div class="meta">

		<p class="pull-left">
			<span class="post-score ui tiny label" itemprop="aggregateRating">{{ $post['score'] }}</span>
			<a class="post-subreddit" href="/r/{{ $post['subreddit'] }}" itemprop="about">
				{{ $post['subreddit'] }}
			</a>
			•
			<span class="post-time">
				<time datetime="{{ date('Y-m-d', time($post['created'])) }}" itemprop="datePublished uploadDate">
					{{ $post['timeago'] }}
				</time> ago
			</span>
			•
			<a class="post-author" href="/u/{{ $post['author'] }}" itemprop="author">{{ $post['author'] }}</a>
		</p>

		<p class="post-domain pull-right">{{ $post['domain'] }}</p>

	</div>

</div>
