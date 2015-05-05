<?php

	$comment = $comment['data'];
	$hasReplies = isset($comment['replies']['data']['children']) && !empty($comment['replies']['data']['children']);

?>

<div class="comment @if ($hasReplies) has-replies @endif">

	<div class="content">

		@if (isset($comment['author']))

			{{-- toggle --}}
			@if ($hasReplies)
				<button class="toggle-replies ui micro button" title="Collapse comments">
					<i class="fa fa-minus"></i>
				</button>
			@endif

			{{-- author --}}
			<a class="author @if ($comment['author'] === $post['author']) op @endif"
				title="@if ($comment['author'] === $post['author']) The OP @else Comment author @endif"
				href="/u/{{ $comment['author'] }}">
				{{ $comment['author'] }}
			</a>

			{{-- meta --}}
			<div class="metadata">

				{{-- karma --}}
				<span title="Comment Karma">{{ $comment['score'] or '0' }} points</span>

				{{-- time --}}
				<span title="Time of submission">
					<time datetime="" itemprop="datePublished uploadDate">
						{{ $comment['created'] or '0' }}
					</time>
				</span>

				{{-- flair --}}
				@if (isset($comment['author_flair_text']) && !is_null($comment['author_flair_text']))
					<span class="flair" title="Subreddit flair"> {{ $comment['author_flair_text'] }}</span>
				@endif

				{{-- gold --}}
				@if (isset($comment['gilded']) && $comment['gilded'] === 1)
					<span class="fa-stack gilded" title="The user has received Gold for this comment">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-star fa-stack-1x"></i>
					</span>
				@endif

			</div>

			{{-- content --}}
			<p class="text">
				{{ $comment['body'] }}
			</p>

			{{-- actions --}}
			<div class="actions">

				{{-- votes --}}
				<div class="ui icon buttons">
					<button class="upvote ui micro button" title="Updvote">
						<i class="fa fa-arrow-up"></i>
					</button>
					<button class="downvote ui micro button" title="Downvote">
						<i class="fa fa-arrow-down"></i>
					</button>
				</div>

				{{-- reply --}}
				<a class="reply" href="#">Reply</a>

				{{-- save --}}
				<a class="save" href="#">Save</a>

			</div>


		</div>

	@else

		{{-- load more --}}
		<a href="#" class="load-more-comments"
			data-parent="{{ $comment['parent_id'] }}"
			data-children="@foreach ($comment['children'] as $value){{ $value . ',' }}@endforeach">
			Load more comments
		</a>

	@endif

	{{-- replies --}}
	@if ($hasReplies)

    	<div class="comments">

			<?php $replies = $comment['replies']['data']['children'] ?>

			@foreach ($replies as $key => $comment)

				@include('posts.post-comment')

			@endforeach

		</div>

	@endif

</div>

