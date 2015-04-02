@if (!empty($comments))

	{{-- comments --}}
	<aside class="comments-wrapper">

		{{-- panel-comments --}}
		<div class="panel panel-comments">

			{{-- panel-heading --}}
			<div class="panel-heading">
				{{ $post['title'] }}

				<!-- Single button -->

				<ul class="btn-toolbar list-inline pull-right">

					{{-- toggle comments --}}
					<li class="btn-group">
						<a class="btn btn-secondary btn-xs toggle-comments" title="Toggle comments" >
							<i class="fa fa-plus-square fa-fw" data-toggle="fa-plus-square"></i>
						</a>
					</li>

					{{-- sort by --}}
					<li class="btn-group">
						<button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-sort fa-fw"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							@foreach (Config::get('reddit.sortOptions') as $key => $value)
								<li @if ($value === $sort)class="active"@endif>
									<a href="{{ $url }}/{{ $value }}">{{ ucfirst($value) }}</a>
								</li>
							@endforeach
						</ul>
					</li>

					{{-- write post --}}
					<li class="btn-group">
						<button class="btn btn-secondary btn-xs" title="Write a comment">
							<i class="fa fa-pencil fa-fw"></i>
						</button>
					</li>

				</ul>
			</div>{{-- / panel-heading --}}

			{{-- panel-body --}}
			<div class="panel-body">

				<ul class="comments">

					@foreach ($comments as $key => $comment)

						@include('posts.post-comment')

					@endforeach
				</ul>

			</div>{{-- / panel-body --}}

		</div>{{-- / panel-comments --}}

	</aside>{{-- / comments --}}

@endif
