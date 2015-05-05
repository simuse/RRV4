{{-- comments --}}
<div class="ui threaded comments">

	@foreach ($comments as $key => $comment)

		@include('posts.post-comment')

	@endforeach

</div>
