<?php $type = $post['type'] ?>

<article class="post post-type-{{ $type }}" itemscope itemtype="https://schema.org/MediaObject">

	<div class="ui fluid card">

		<div class="content">

			@include('posts.post-header')

			<div class="post-content">

				@if (Request::has('debug'))
					@include('posts.post-type-debug')
				@else
					@include('posts.post-type')
				@endif

			</div>

		</div>

		@include('posts.post-footer')

	</div>

	@if (isset($post['thumbnail']))
		<meta itemprop="thumbnail" content="{{ $post['thumbnail'] }}" />
	@endif

</article>
