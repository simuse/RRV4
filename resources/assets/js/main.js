/* ======================================================
*  Scripts
*
* @todo GridMode : show meta on hover
*
*  =====================================================*/

jQuery(document).ready(function($) {

	/* Common - Get User settings via Cookies
	---------------------------------------------- */
	if (readCookie('layout')) {
		window.settings.layout = readCookie('layout');
	}

	/* Common - Init dropdowns
	---------------------------------------------- */
	$('.dropdown').dropdown({
	    transition: 'fade down'
	});

	/* Header - Toggle Sidebar
	---------------------------------------------- */
	$('#sidebar-toggle').on('click', function(e) {
		e.preventDefault();
		$('#sidebar').sidebar('toggle');
	});

	/* Sidebar - Open login form
	---------------------------------------------- */
  	$('#modal-login').on('click', function() {
  		$('.ui.modal').modal().modal('show');
  	});

	/* Posts - Lazy Loading
	---------------------------------------------- */
	$('.post-image img, iframe').unveil(200, function() {
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

			// post-heading event
			// $posts.each(function() {
			// 	var $header = $(this).find('.header'),
			// 		$meta = $(this).find('.meta');

			// 	$header.on('mouseenter', function() {
			// 		$meta.stop().slideDown();
			// 	}).on('mouseleave', function() {
			// 		$meta.stop().slideUp();
			// 	});
			// });

		} else if (layout === 'list') {

			$('.post').removeClass('isotope');
			$('#posts').isotope('destroy');
			// $('.posts .header').off('mouseenter');
			// $('.posts .header').off('mouseleave');

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

	// $('#toggle-layout').on('click', function() {
	// 	var layout = (window.settings.layout === 'list') ? 'grid' : 'list';
	// 	setLayout(layout);
	// 	$(this).find('i').toggleClass('fa-th-list').toggleClass('fa-th');
	// });

	if ((window.settings.layout === 'grid') && (window.settings.view === 'index')) {
		setLayout('grid');
	}

	/* Posts - Share - Twitter
	---------------------------------------------- */
	$('.share-twitter').on('click', function(e) {
		e.preventDefault();

		var url = window.settings.root + '/p/' + $(this).data('id'),
			text = $(this).closest('.post').find('.post-title').text();

		text += ' <on Red.It>';

		window.open('http://twitter.com/share?url=' + url + '&text=' + text + '&', 'twitterwindow', 'height=450, width=550, top='+($(window).height()/2 - 225) +', left='+($(window).width()/2 - 225)+', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
	});

	/* Posts - Share - Google
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

	/* Images loaded
	---------------------------------------------- */
	// $('#posts').imagesLoaded(function() {

	// 	$('#toggle-layout').removeClass('disabled');
	// 	setLoader(100);
	// 	clearInterval(loaderInt);
	// 	setTimeout(function() {
	// 		hideLoader();
	// 	}, 500);
	// });

	// $(window).load(function() {
	// 	setLoader(100);
	// });

	/* Comments: toggle replies
	---------------------------------------------- */
	// $('.toggle-replies').on('click', function(e) {
	// 	e.preventDefault();

	// 	$(this).find('i').toggleIcon();

	// 	$(this).closest('li').children('.comment-replies').toggleClass('comment-replies-hidden');

	// });

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
















