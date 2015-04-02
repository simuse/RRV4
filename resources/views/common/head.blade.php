{{-- meta --}}
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- title --}}
<title>
	@if (isset($subreddit)){{ $subreddit }} |
	{{-- @elseif (isset($viewName) && $viewName === 'single') {{ $post['title'] }} | --}}
	@endif Red.It
</title>

{{-- css --}}
<link href="{{ url('/assets/css/semantic.min.css') }}" rel="stylesheet">
<link href="{{ url('/assets/css/main.css') }}" rel="stylesheet">

{{-- fonts --}}
<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
