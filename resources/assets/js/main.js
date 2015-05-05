/* ======================================================
*  Scripts
*  =====================================================*/

jQuery(document).ready(function($) {

	var $win = $(window),
		$body = $('body'),
		winH = $win.height();

	$win.on('resize', function() {
		winH = $win.height();
	});

/* ======================================================
*  Common
*  =====================================================*/

	/* Common - Init dropdowns
	---------------------------------------------- */
	$('.dropdown').dropdown({
	    transition: 'scale'
	});

	/* Common - Init popups
	---------------------------------------------- */
	$('.toggle-popup').popup({
    	on: 'click'
  	});

/* ======================================================
*  Header
*  =====================================================*/

	/* Header - Toggle Sidebar
	---------------------------------------------- */
	$('#sidebar-toggle').on('click', function(e) {
		e.preventDefault();
		$('#sidebar').sidebar('setting', 'transition', 'overlay').sidebar('toggle');
	});

	/* Header - Open Login modal
	---------------------------------------------- */
  	$('#toggle-modal-login').on('click', function() {
  		$('#modal-login').modal().modal('show');
  	});

	/* Header - Autocomplete
	---------------------------------------------- */
	// Autocompeter(document.getElementById('input-subreddit'), {
	// 	number: 20
	// });

/* ======================================================
*  Sidebar
*  =====================================================*/

  	/* Sidebar - Open About modal
	---------------------------------------------- */
  	$('#toggle-modal-about').on('click', function() {
  		$('#modal-about').modal().modal('show');
  	});

/* ======================================================
*  Posts
*  =====================================================*/

	/* Posts - Lazy Loading
	---------------------------------------------- */
	$('.post-image img, iframe, .post-oembed-image img').unveil(200, function() {
		$(this).load(function() {
			this.style.opacity = 1;

			if (window.settings.layout === 'grid') {
				$('#posts').isotope('layout');
			}
		});
	});

	/* Posts - Fancybox
	---------------------------------------------- */
	$('.post-image').fancybox({
		autoResize: true,
		closeBtn: false,
		margin: 15,
		mouseWheel: true,
		helpers: {
			overlay: {
				locked: false
			}
		}
	});

	/* Posts - Toggle Layout
	---------------------------------------------- */
	var setLayout = function(layout) {

		if (layout === 'grid') {

			var $posts = $('.post');

			// isotope
			$posts.addClass('isotope');
			$('#posts').isotope({
				itemSelector: '.post',
				layoutMode: 'masonry',
			});

			initPostPopover();

		} else if (layout === 'list') {

			$('.post').removeClass('isotope');
			$('#posts').isotope('destroy');

			destroyPostPopover();

		}

		window.settings.layout = layout;

		createCookie('layout', window.settings.layout, 30);

	};

	$('.set-layout').on('click', function(e) {
		e.preventDefault();
		$('.set-layout').removeClass('active');
		$(this).addClass('active');
		setLayout($(this).data('layout'));
	});

	if ((window.settings.layout === 'grid') && (window.settings.view === 'index')) {
		setLayout('grid');
	}

	/* Posts - toggle post-header popover on Isotope layout
	---------------------------------------------- */
	function initPostPopover() {
		$('.post-heading').popup({
			className: {
				popup: 'ui fluid popup',
			},
			delay: {
				show: 20,
				hide: 2000,
			},
			duration: 300,
			exclusive: false,
			hideOnScroll: false,
			hoverable: true,
			inline   : true,
			position : 'bottom left',
			transition: 'fade',
		});
	}

	function destroyPostPopover() {
		$('.post-heading').popup('destroy');
	}

/* ======================================================
*  Comments
*  =====================================================*/

	/* Comments - Toggle Replies
	---------------------------------------------- */
	$('.toggle-replies').on('click', function(e) {
		e.preventDefault();
		$(this).find('.fa').toggleClass('fa-plus').toggleClass('fa-minus');
		$(this).parent().siblings('.comments').toggle();
	});

	/* Comments - load more comments
	---------------------------------------------- */
	$('.load-more-comments').on('click', function(e) {
		e.preventDefault();
		console.log(this);
	});

/* ======================================================
*  Sharing
*  =====================================================*/

	/* Share - Twitter
	---------------------------------------------- */
	$('.share-twitter').on('click', function(e) {
		e.preventDefault();

		var url = window.settings.root + '/p/' + $(this).data('id'),
			text = $(this).closest('.post').find('.post-title').text();

		text += ' <on Red.It>';

		window.open('http://twitter.com/share?url=' + url + '&text=' + text + '&', 'twitterwindow', 'height=450, width=550, top='+($(window).height()/2 - 225) +', left='+($(window).width()/2 - 225)+', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
	});

	/* Share - Google
	---------------------------------------------- */
	$('.share-google').on('click', function(e) {
		e.preventDefault();

		var url = window.settings.root + '/p/' + $(this).data('id'),
			text = $(this).closest('.post').find('.post-title').text();

		text += ' <on Red.It>';

		window.open('https://plus.google.com/share?url=' + url + '&text=' + text, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=550,top='+($(window).height()/2 - 225) +', left='+($(window).width()/2 - 225));
	});

	/* Posts - Share - Facebook
	---------------------------------------------- */
	// $(document).on('FBloaded', function() {

	// 	$('.fb-share').on('click', function(e) {
	// 		e.preventDefault();

	// 		FB.ui({
	// 			caption: 'Freeligion',
	// 			description: 'Smile for Freedom and Peace',
	// 		    link: $(this).data('url'),
	// 		    method: 'feed',
	// 		    name: 'Share a smile for peace',
	// 		    picture: $(this).data('picture'),
	// 		    redirect: false
	// 		}, function(response) {
	// 		    if (response && !response.error_code) {
	// 		    	console.log('FB share: Posting completed.');
	// 		    } else {
	// 		    	console.log('FB share: Error while posting.');
	// 		    }
	// 		});
	// 	});

	// });

	/* Common - Form validation
	---------------------------------------------- */
	// $('#formLogin').form({
	// 	username: {
	// 		identifier: 'username',
	// 		rules: [
	// 			{
	// 				type: 'empty',
	// 				prompt: 'Please enter your username'
	// 			}
	// 		]
	// 	},
	// 	password: {
	// 		identifier: 'password',
	// 		rules: [
	// 			{
	// 				type: 'empty',
	// 				prompt: 'Please enter your password'
	// 			}
	// 		]
	// 	}
	// });

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

	/* Loader
	---------------------------------------------- */
	// var loaderValue = 0;

	// var loaderInt = setInterval(function() {
	// 	loaderValue = loaderValue + 10;
	// 	setLoader(loaderValue);
	// 	if (loaderValue >= 100) {
	// 		clearInterval(loaderInt);
	// 	}
	// },2000);

	// function setLoader(value) {
	// 	var $loader = $('#page-loader'),
	// 		$bar = $loader.find('.bar');

	// 	$bar.css('width', value+'%');
	// }

	// function hideLoader() {
	// 	$('#page-loader').fadeOut();
	// }

	// setLoader(10);

	/* Comments: toggle all comment
	 * @todo disturbs icons and order of already closed comments
	---------------------------------------------- */
	// $('.toggle-comments').on('click', function(e) {
	// 	e.preventDefault();

	// 	$(this).find('i').toggleIcon();

	// 	$('.toggle-replies').find('i').toggleIcon();
	// 	$('.comment-replies').toggleClass('comment-replies-hidden');
	// });

	/* Selftext : show full post
	---------------------------------------------- */
	// $('.selftext').each(function() {
	// 	var $this = $(this),
	// 		$button = $this.find('.show-full'),
	// 		height = $this.outerHeight();

	// 	if (height > 250) {
	// 		$this.height(250);
	// 		$button.show().on('click', function() {
	// 			$(this).fadeOut().closest('.selftext').css('height', height);
	// 		});
	// 	}
	// });


});
















