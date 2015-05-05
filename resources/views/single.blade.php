<?php

$post 		= $data['post'];
$comments 	= $data['comments'];

?>

@extends('layouts.master')

@section('content')

	{{-- post --}}
	<div id="post-single">
		@include('posts.post')
	</div>

	{{-- comments --}}
	<div id="comment-actions">
		@include('posts.comment-actions')
	</div>

	<div class="top" id="comments">
		@include('posts.post-comments')
	</div>

@endsection
