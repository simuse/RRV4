{{-- @if (!empty($post->type)) --}}
	<?php $post = $data['post'] ?>

	<article class="post post-type-{{ $post->type }}">

		<div class="panel panel-post">

			@include('posts.post-header')

			<div class="panel-body">

				{{-- image --}}
				@if ($post->type === 'image')

					<a class="lightbox" href="{{ $post->url }}" rel="group" target="_blank">
						<img class="post-img" src="" data-src="{{ $post->url }}" alt="<{{ $post->title }}">
					</a>

				{{-- album --}}
				@elseif ($post->type === 'album')

					<iframe class="post-album" width="100%" height="400" frameborder="0" src="{{ $post->url }}"></iframe>

				{{-- gifv --}}
				@elseif ($post->type === 'iframe')

					<iframe class="post-iframe" width="100%" height="400" frameborder="0" src="{{ $post->url }}"></iframe>

				{{-- reddit --}}
				@elseif ($post->type === 'reddit')
					<div class="selftext">
						<p>{{ $post->selftext }}</p>
						{{-- {!! $post->selftext_html !!} --}}
					</div>

				{{-- video --}}
				@elseif ($post->type === 'video')

					<div class="post-video embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="{{ $post->url }}"></iframe>
					</div>

				{{-- page --}}
				@elseif ($post->type === 'wikipedia')

					<iframe class="post-album" width="100%" height="400" frameborder="0" src="{{ $post->url }}"></iframe>


				{{-- instagram --}}
				@elseif ($post->type === 'instagram')

						<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="4" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; padding:0; width:100%;">
							<div style="padding:8px;">
								<div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50% 0; text-align:center; width:100%;">
									<div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAAGFBMVEUiIiI9PT0eHh4gIB4hIBkcHBwcHBwcHBydr+JQAAAACHRSTlMABA4YHyQsM5jtaMwAAADfSURBVDjL7ZVBEgMhCAQBAf//42xcNbpAqakcM0ftUmFAAIBE81IqBJdS3lS6zs3bIpB9WED3YYXFPmHRfT8sgyrCP1x8uEUxLMzNWElFOYCV6mHWWwMzdPEKHlhLw7NWJqkHc4uIZphavDzA2JPzUDsBZziNae2S6owH8xPmX8G7zzgKEOPUoYHvGz1TBCxMkd3kwNVbU0gKHkx+iZILf77IofhrY1nYFnB/lQPb79drWOyJVa/DAvg9B/rLB4cC+Nqgdz/TvBbBnr6GBReqn/nRmDgaQEej7WhonozjF+Y2I/fZou/qAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div>
								</div>
								<p style=" margin:8px 0 0 0; padding:0 4px;">
									<a href="https://instagram.com/p/zFyb4WDkCs/" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_top">Flying frequently tends to make one either bitter or obsessed with aviation. I fall into the latter category. Visiting Maho Beach in Saint Marteen was always on my bucket list. It&#39;s as crazy as it looks — planes landing just feet from a public beach.</a>
								</p>
								<p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">A video posted by Paul Luning (@pluning) on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2015-02-14T17:45:02+00:00">Feb 14, 2015 at 9:45am PST</time>
								</p>
							</div>
						</blockquote>
						<script async defer src="//platform.instagram.com/en_US/embeds.js"></script>
				@else
					<h4>Unknown Type </h4>
					<p><a href="{{ $post->url }}">{{ $post->url }}</a></p>
					<p>{{ $post->domain }}</p>
					<?php d($post) ?>
				@endif

			</div>{{-- / panel-body --}}

			@include('posts.post-footer')

		</div>{{-- / panel-post --}}

	</article>{{-- / post --}}


	@if (!empty($data['comments']))

		{{-- comments --}}
		<aside class="comments-wrapper">

			<div class="panel panel-comments">

				<div class="panel-body">

					<ul class="comments">
						@foreach ($data['comments'] as $key => $value)

							<?php $comment = $value->data ?>

							<li>
								<p><small><strong>{{ $comment->author }}</strong> - <span class="badge badge-muted">{{ $comment->score }}</span></small></p>
								<p>{{ $comment->body }}</p>

								@if (!empty($comment->replies))
									<ul>

										<?php $replies = $comment->replies->data->children ?>

										@foreach ($replies as $k => $v)

											<?php $reply = $v->data ?>

											<li>
												<p><small><strong>{{ $reply->author }}</strong> - <span class="badge badge-muted">{{ $reply->score }}</span></small></p>
												<p>{{ $reply->body }}</p>
											</li>

										@endforeach
									</ul>
								@endif
							</li>
						@endforeach
					</ul>

				</div>

			</div>

		</aside>{{-- / comments --}}

	@endif

{{-- @endif --}}














