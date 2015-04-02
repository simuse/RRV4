
<article class="post post-type-{{ $post['type'] }}">

	<div class="panel panel-post">

		@include('posts.post-header')

		<div class="panel-body">

			{{-- image --}}
			@if ($post['type'] === 'image')
				<a class="lightbox" href="{{ $post['url'] }}" rel="group" target="_blank">
					<h1>Image</h1>
					{{-- <img class="post-img" src="" data-src="{{ $post['url'] }}" alt="{{ $post['title'] }}"> --}}
				</a>

			{{-- image --}}
			@elseif ($post['type'] === 'gif')
				<a class="lightbox" href="{{ $post['url'] }}" rel="group" target="_blank">
					<h1>GIF</h1>
					{{-- <img class="post-img post-gif freezeframe" src="" data-src="{{ $post['url'] }}" alt="{{ $post['title'] }}"> --}}
				</a>

			{{-- album --}}
			@elseif ($post['type'] === 'album')
				<h1>Album</h1>
				{{-- <iframe class="post-album" width="100%" height="600" frameborder="0" src="{{ $post['url'] }}"></iframe> --}}

			{{-- gifv --}}
			@elseif ($post['type'] === 'iframe')
				<h1>GIFV</h1>
				{{-- <iframe class="post-iframe" width="100%" height="400" frameborder="0" src="{{ $post['url'] }}"></iframe> --}}

			{{-- self --}}
			@elseif ($post['type'] === 'reddit')
				<div class="selftext">
					<p>{{ $post['selftext'] }}</p>
					<button class="btn btn-secondary text-center btn-block show-full">
						<i class="fa fa-angle-double-down"></i>
						Show all
						<i class="fa fa-angle-double-down"></i>
					</button>
					{{-- {!! $post['selftext_html'] !!} --}}
				</div>

			{{-- video --}}
			@elseif ($post['type'] === 'video')
				<h1>Video</h1>
				{{-- <div class="post-video embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="" data-src="{{ $post['url'] }}"></iframe>
				</div> --}}

			{{-- page --}}
			@elseif ($post['type'] === 'wikipedia')
				<h1>Wikipedia</h1>
				{{-- <iframe class="post-album" width="100%" height="400" frameborder="0" src="{{ $post['url'] }}"></iframe> --}}

			{{-- oembed --}}
			@elseif ($post['type'] === 'oembed')
				<h1>OEmbed</h1>
				<?php d($post['oembed']) ?>
				{{-- <iframe class="post-album" width="100%" height="400" frameborder="0" src="{{ $post['url'] }}"></iframe> --}}

			{{-- unknown --}}
			@else
				<h4>Unknown Type </h4>
				<p><a href="{{ $post['url'] }}">{{ $post['url'] }}</a></p>
				<p>{{ $post['domain'] }}</p>
				<?php d($post) ?>
			@endif

		</div><!-- / panel-body -->

		@include('posts.post-footer')

	</div><!-- / post -->

</article><!-- / posts -->
