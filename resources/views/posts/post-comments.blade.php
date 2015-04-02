<br>

{{-- reply form --}}
<form class="ui reply form">

	<div class="field">
		<textarea placeholder="Your comment" style="height: 4em; min-height: 3em"></textarea>
	</div>

	<div class="ui blue labeled submit icon button">
		<i class="icon edit"></i>
		Reply
	</div>

</form>

<br>
<hr>
<br>

@if (!empty($comments))
{{-- grid --}}
<div class="ui grid">

	{{-- comments --}}
	<div class="twelve wide column">

		<div class="ui threaded comments" style="max-width: none">

			@foreach ($comments as $key => $comment)

				@include('posts.post-comment')

			@endforeach

		</div>

	</div>

	{{-- menu --}}
    <div class="four wide column">

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
