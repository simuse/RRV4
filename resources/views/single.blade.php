@extends('layouts.master')

@section('header')

	@include('common.header.index')

@endsection

@section('content')

	<div id="posts">

		<?php
			$post = $data['post'];
			$comments = $data['comments'];
		?>

		@include('posts.post')

		@include('posts.post-comments')

	</div>
@endsection
