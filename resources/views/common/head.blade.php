{{-- meta --}}
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- title --}}
<title>
	@if (isset($viewName) && $viewName === 'single') {{ $post['title'] }} | @endif
	@if (isset($subreddit)){{ $subreddit }} | @endif
	Red.It
</title>

{{-- css --}}
@if (getenv('APP_ENV') === 'local')
	<link href="{{ url('/assets/css/main.css') }}" rel="stylesheet">
@else
	<link href="{{ url('/assets/css/main.min.css') }}" rel="stylesheet">
@endif

{{-- fonts --}}
<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
