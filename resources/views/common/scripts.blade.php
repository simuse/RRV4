{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}

{{-- javascript settings --}}
<script>

window.settings = {
	@foreach ($javascriptSettings as $key => $value)
		'{{ $key }}': '{{ $value }}',
	@endforeach
}

</script>

<script src="{{ url('/assets/js/jquery.min.js') }}"></script>
<script src="{{ url('/assets/js/plugins.js') }}"></script>
<script src="{{ url('/assets/js/main.js') }}"></script>
