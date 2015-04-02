<div class="panel-footer">

	<div class="btn-toolbar">

		{{-- votes --}}
		<div class="btn-group" role="group" aria-label="Vote">
			<button class="btn btn-sm btn-default" title="Upvote">
				<i class="fa fa-arrow-up"></i>
			</button>
			<button class="btn btn-sm btn-default" title="Downvote">
				<i class="fa fa-arrow-down"></i>
			</button>
		</div>

		{{-- favorite --}}
		<button class="btn btn-sm btn-default" title="Add to favorites">
			<i class="fa fa-star"></i>
		</button>

		{{-- share --}}
		<div class="btn-group dropdown-social">
			<button class="btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false" title="Share">
				<i class="fa fa-share-alt"></i>
			</button>
			<ul class="dropdown-menu">
				<li><a href="#" title="Share on Facebook"><i class="fa fa-facebook"></i></a></li>
				<li><a href="#" title="Tweet this post"><i class="fa fa-twitter"></i></a></li>
				<li><a href="#" title="Share on Google+"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="#" title="Pin on Pinterest"><i class="fa fa-pinterest"></i></a></li>
				<li><a href="#" title="Share via email"><i class="fa fa-envelope"></i></a></li>
			</ul>

		</div>

		{{-- comments --}}
		@if ($viewName !== 'single')
			<button class="btn btn-sm btn-default pull-right" title="View comments">
				<i class="fa fa-comment"></i>
				{{ $post['num_comments'] }}
			</button>
		@endif

		{{-- reddit --}}
		<a class="btn btn-sm btn-default pull-right" href="http://www.reddit.com{{ $post['permalink'] }}" target="_blank" title="View on Reddit">
			<i class="fa fa-reddit"></i>
		</a>

	</div><!-- / panel-footer -->

</div><!-- / panel-footer -->
