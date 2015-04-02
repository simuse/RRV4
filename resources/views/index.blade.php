@extends('layouts.master')

@section('header')

	@include('common.header.index')

@endsection

@section('content')

	<div class="ui grid" id="posts" style="padding-top: 40px">

		<?php foreach ($data['posts'] as $key => $post): ?>

			@include('posts.post')

		<?php endforeach ?>
	</div>

@endsection
