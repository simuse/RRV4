<?php

$post 		= $data['post'];
$comments 	= $data['comments'];

?>

@extends('layouts.master')

@section('content')

	<div id="posts">

		@include('posts.post')

	</div>

	<div id="reply">

		@include('posts.post-reply')

	</div>

	<div id="comments">

		@include('posts.post-comments')

	</div>

@endsection
