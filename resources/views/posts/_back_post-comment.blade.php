<?php

	$comment = $comment['data'];
	$hasReplies = isset($comment['replies']->data->children) && !empty($comment['replies']->data->children);

?>

<li class="comment">

	<p>
		@if ($hasReplies)
			<a class="toggle-replies" href="#" title="Toggle comment's replies"><i class="fa fa-minus-square" data-toggle="fa-plus-square"></i></a>
		@endif

		<small>
			<strong>{{ $comment['author'] or '[deleted]' }}</strong> -
			<span class="badge badge-muted" title="Comment Karma">{{ $comment['score'] or '0' }}</span>

			{{-- flair --}}
			@if (isset($comment['author_flair_text']) && !is_null($comment['author_flair_text']))
				- <span class="flair"> {{ $comment['author_flair_text'] }}</span>
			@endif

			{{-- gold --}}
			@if (isset($comment['gilded']) && $comment['gilded'] === 1)
				- <span class="fa-stack gilded" title="The user has received Gold for this comment">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-star fa-stack-1x"></i>
				</span>
			@endif

		</small>
	</p>

	<p>{{ $comment['body'] or '[deleted]' }}</p>

	@if ($hasReplies)

		<ul class="comment-replies">

			<?php $replies = $comment['replies']->data->children ?>

			@foreach ($replies as $key => $comment)

				@include('posts.post-comment')

			@endforeach

		</ul>

	@endif

</li>
