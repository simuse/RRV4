<?php

	$comment = $comment['data'];
	$hasReplies = isset($comment['replies']['data']['children']) && !empty($comment['replies']['data']['children']);

?>

<div class="comment">

	<div class="content">

		<a class="author" href="#">{{ $comment['author'] or '[deleted]' }}</a>

		{{-- meta --}}
		<div class="metadata">

			<span class="label" title="Comment Karma">{{ $comment['score'] or '0' }}</span>

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

		</div>

		{{-- content --}}
		<p class="text">
			{{ $comment['body'] or '[deleted]' }}
		</p>

		{{-- actions --}}
		<div class="actions">
			<a class="upvote" href="#"><i class="fa fa-arrow-up"></i></a>
			<a class="downvote" href="#"><i class="fa fa-arrow-down"></i></a>
			<a class="reply" href="#">Reply</a>
			<a class="save" href="#">Save</a>
		</div>

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

</div>

