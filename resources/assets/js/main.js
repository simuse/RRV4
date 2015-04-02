/* ======================================================
*  Scripts
*  =====================================================*/

jQuery(document).ready(function($) {

	/* Fancybox
	---------------------------------------------- */
	$('.lightbox').fancybox({
		autoResize: true,
		closeBtn: false,
		mouseWheel: true,
		// autoPlay: true
	});

	/* Isotope
	---------------------------------------------- */
	function initIsotope() {
		$('#posts').isotope({
			itemSelector: '.post',
			layoutMode: 'masonry',
		});
		window.options.layout = 'masonry';
	}

	function destroyIsotope() {
		$('#posts').isotope('destroy');
		window.options.layout = 'default';
	}

	function triggerIsotope() {
		$('#posts').isotope('layout');
	}

	/* Toggle layout
	---------------------------------------------- */
	$('#toggle-layout').on('click', function() {

		if ($('body').hasClass('layout-masonry')) {
			$('body').removeClass('layout-masonry');
			destroyIsotope();
			$(this).find('i').removeClass('fa-list');
		} else {
			$('body').addClass('layout-masonry');
			initIsotope();
			$(this).find('i').addClass('fa-list');
		}

	});

	/* Lazy load
	---------------------------------------------- */
	$('img').unveil(200, function() {
		$(this).load(function() {
			this.style.opacity = 1;
			if (window.options.layout === 'masonry') {
				triggerIsotope();
				// freezeframe.run();
			}
		});
	});

	$('iframe').unveil(500,function() {
		$(this).load(function() {
			this.style.opacity = 1;
			if (window.options.layout === 'masonry') {
				triggerIsotope();
			}
		});
	});

	/* FreezeFrame: pause gifs
	---------------------------------------------- */
	// var freezeframe_options = {
	// 	animation_icon_position: 'center center',
	// 	class_name: 'post-gif',
	// 	loading_background_color: 'red',
	// 	loading_fade_in_speed: 300,
	// 	trigger_event: 'click',
	// };
	// freezeframe.run();

	/* Sidebar toggle
	---------------------------------------------- */
	$('#sidebar-toggle').on('click', function() {

		$('#sidebar-main').toggleClass('open');
		$('body').toggleClass('sidebar-open');
		$(this).toggleClass('active').find('i').toggleIcon();

		if (window.options.layout === 'masonry') {
			setTimeout(function() {
				triggerIsotope();
			}, 400);
		}

	});

	/* Loader
	---------------------------------------------- */
	var loaderValue = 0;

	var loaderInt = setInterval(function() {
		loaderValue = loaderValue + 10;
		setLoader(loaderValue);
		if (loaderValue >= 100) {
			clearInterval(loaderInt);
		}
	},2000);

	function setLoader(value) {
		var $loader = $('#page-loader'),
			$bar = $loader.find('.bar');

		$bar.css('width', value+'%');
	}

	function hideLoader() {
		$('#page-loader').fadeOut();
	}

	setLoader(10);

	/* Images loaded
	---------------------------------------------- */
	$('#posts').imagesLoaded(function() {

		$('#toggle-layout').removeClass('disabled');
		setLoader(100);
		clearInterval(loaderInt);
		setTimeout(function() {
			hideLoader();
		}, 500);
	});

	$(window).load(function() {
		setLoader(100);
	});

	/* Comments: toggle replies
	---------------------------------------------- */
	$('.toggle-replies').on('click', function(e) {
		e.preventDefault();

		$(this).find('i').toggleIcon();

		$(this).closest('li').children('.comment-replies').toggleClass('comment-replies-hidden');

	});

	/* Comments: toggle all comment
	 * @todo disturbs icons and order of already closed comments
	---------------------------------------------- */
	$('.toggle-comments').on('click', function(e) {
		e.preventDefault();

		$(this).find('i').toggleIcon();

		$('.toggle-replies').find('i').toggleIcon();
		$('.comment-replies').toggleClass('comment-replies-hidden');
	});

	/* Selftext : show full post
	---------------------------------------------- */
	$('.selftext').each(function() {
		var $this = $(this),
			$button = $this.find('.show-full'),
			height = $this.outerHeight();

		if (height > 250) {
			$this.height(250);
			$button.show().on('click', function() {
				$(this).fadeOut().closest('.selftext').css('height', height);
			});
		}
	});


});
















