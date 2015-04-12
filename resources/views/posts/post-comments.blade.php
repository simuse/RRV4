@if (!empty($comments))

<div class="row">

	{{-- comments --}}
	<div class="col-xs-9">

		<div class="ui threaded comments">

			@foreach ($comments as $key => $comment)

				@include('posts.post-comment')

			@endforeach

		</div>

	</div>

	{{-- menu --}}
    <div class="col-xs-3">

		<div class="ui small vertical menu fluid">

			<a class="active teal item">Best</a>
			<a class="item">Top</a>
			<a class="item">New</a>
			<a class="item">Hot</a>
			<a class="item">Controversial</a>

			<div class="item">
				<div class="ui icon input">
					<input type="text" placeholder="Search comments...">
					<i class="search icon"></i>
				</div>
			</div>

		</div>

    </div>

</div>

@endif
