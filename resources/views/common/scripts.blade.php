<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ url('/assets/js/plugins.js') }}"></script>
<script src="{{ url('/assets/js/main.js') }}"></script>

<script>

	window.options = {
		layout: "{{ 'default' }}"
	}

	jQuery(document).ready(function($) {
		$('.dropdown').dropdown({
		    transition: 'drop'
  		});
	});

</script>

<style>
	.wrap {
		width: 90%;
		margin: 40px auto;
	}
	img{
		max-width: 100%;
		height: auto;
	}
</style>
