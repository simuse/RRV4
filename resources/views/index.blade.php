<?php

$posts = $data['posts'];

?>

@extends('layouts.master')

@section('content')

	<div class="row" id="posts">

		<?php foreach ($data['posts'] as $key => $post): ?>

			@include('posts.post')

		<?php endforeach ?>

	</div>

@endsection
