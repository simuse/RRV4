@extends('layouts.master')

@section('content')

	<div class="row" id="posts">

		{{-- posts --}}
		@if (!empty($data['posts']))

			<?php foreach ($data['posts'] as $key => $post): ?>

				@include('posts.post')

			<?php endforeach ?>

		{{-- no posts found --}}
		@else

			<div class="container">
				<div class="ui segment red">
					<p>{{ Lang::get('errors.posts_not_found') }}</p>
					<a href="{{ url('/') }}">Go home</a>
				</div>
			</div>

		@endif

	</div>

@endsection
