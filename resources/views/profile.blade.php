<?php

$about 		= $data['user']['about'];
$submitted 	= $data['user']['submitted'];
$comments 	= $data['user']['comments'];

?>

@extends('layouts.master')

@section('content')

	<h1>{{ $about['name'] }}</h1>

	<div class="row">

		<div class="col-sm-8">

			@foreach($submitted as $key => $post)
				@include('posts.post')
			@endforeach

		</div>

		<div class="col-sm-4">
			<div class="ui top attached segment">
				<p>Redditor since {{ $about['created'] }}</p>
			</div>
			<div class="ui attached segment">
				<p><span class="ui label">{{ $about['comment_karma'] }}</span> Comment Karma </p>
			</div>
			<div class="ui bottom attached segment">
				<p><span class="ui label">{{ $about['link_karma'] }}</span> Link Karma </p>
			</div>
		</div>

	</div>

@endsection
