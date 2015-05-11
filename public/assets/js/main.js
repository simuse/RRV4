/**
 * Red.It - v0.0.3
 * http://reddit.simonvreux.be
 *
 * Author: Simon Vreux <simon.vreux@gmail.com>
 * License: MIT (http://opensource.org/licenses/MIT)
 * Updated: 11-05-2015
 */
/**
 * Save a cookie in the browser
 * @param {string} name
 * @param {string} value
 * @param {integer} days
 */
function createCookie(name,value,days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = '; expires='+date.toGMTString();
    } else {
    	expires = '';
    }
    document.cookie = name+'='+value+expires+'; path=/';
}

/**
 * Returns the value of a cookie
 * @param {string} name
 * @return {string | boolean}
 */
function readCookie(name) {
    var n = name + '=';
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') {
        	c = c.substring(1,c.length);
        }
        if (c.indexOf(n) === 0) {
        	return c.substring(n.length,c.length);
        }
    }
    return false;
}

/**
 * Deletes a cookie
 * @param {string} name
 */
function eraseCookie(name) {
    createCookie(name,'',-1);
}
;(function ($) {

    var Extend = {

        /**
         * Give the selector and it's argument the same height
         * @author  Simon Vreux <simon@cherrypulp.com>
         */
        sameHeight: function (el) {
            return this.each(function () {
            	var h1 = $(this).height(),
            		h2 = el.height();

            	if (h1 < h2) {
            		$(this).height(h2);
            	} else {
            		el.height(h1);
            	}
            });
        },

		/**
    	 * Make the selector scroll back to top on click
		 * @author  Simon Vreux <simon@cherrypulp.com>
		 * @param  {int} offset from when the button should be visible
		 */
		scrollToTop: function(offset, duration) {
			return this.each(function() {
				var $this = $(this),
					$win = $(window),
					offset = offset || 300,
					duration = duration || 300;

				$win.scroll(function() {
			        if ($win.scrollTop() >= offset) {
			            $this.addClass('visible');
			        } else {
			            $this.removeClass('visible');
			        }
			    });

				$this.on('click', function(e) {
					e.preventDefault();
			        $('html, body').stop().animate({
			            scrollTop: 0
			        }, duration);
			    });

			});
		},

		/**
		 * Toggle the FontAwesome class for an icon
		 *
    	 * @version  1.0.0
		 * @author   Simon Vreux <simon@cherrypulp.com>
		 * @example  $('i').toggleIcon('fa-edit');
		 * @param    {string} newIcon new icon class
		 */
		toggleIcon: function(newIcon) {
			return this.each(function() {
				var $this = $(this),
					oldIcon = $this.attr('class').substring(3);

				if (typeof newIcon === 'undefined') {
					newIcon = $this.data('toggle');
				}

				$this.removeClass(oldIcon).addClass(newIcon).data('toggle', oldIcon);

			});
		}

    };

    $.extend($.fn, Extend);

}) (window.jQuery);
;;(function ( $, window, document, undefined ) {

    "use strict";

        // defaults
        var pluginName = "loading",
                defaults = {
                propertyName: "value"
        };

        // plugin constructor
        function Loading ( element, options ) {
            this.element = element;
            this.settings = $.extend( {}, defaults, options );
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        // Avoid Plugin.prototype conflicts
        $.extend(Loading.prototype, {

            init: function () {
                console.log(this.destroy);
                // Place initialization logic here
                // You already have access to the DOM element and
                // the options via the instance, e.g. this.element
                // and this.settings
                // you can add more functions like the one below and
                // call them like so: this.yourOtherFunction(this.element, this.settings).
                console.log("xD");
            },

            destroy: function () {
                console.log('desctroy');
            }

        });

        // A really lightweight plugin wrapper around the constructor,
        // preventing against multiple instantiations
        $.fn[ pluginName ] = function ( options ) {
            return this.each(function() {
                if ( !$.data( this, "plugin_" + pluginName ) ) {
                    $.data( this, "plugin_" + pluginName, new Loading( this, options ) );
                }
            });
        };

})( jQuery, window, document );





;(function ($) {
    $.extend({
        notify: function (content, options) {
            // defaults
            var settings = $.extend({
                animationIn: 'fadeInDown', // [string or false] animation from animate.less
                animationOut: 'fadeOutUp', // [string or false] animation from animate.less
                autoHide: 5000,            // [integer or false] time in ms before hiding notif
                dismissable: true,         // [boolean] hide notif on click
                icon: null,                // [string] the name of an icon from FontAwesome (http://fortawesome.github.io/Font-Awesome/icons/)
                iconPosition: 'left',      // [string] position of the icon relative to the text
                position: 'top right',     // [string] position x and y of the notif
                type: 'info',              // [string] type of notif (info, warning, error, success)

                onShow: null,              // [function] callback
                onHide: null,              // [function] callback
            }, options ),
            s = settings;

            // check type
            var _validTypes = ['info', 'warning', 'error', 'danger', 'success'];
            if (_validTypes.indexOf(s.type) < 0) {
                s.type = 'info';
            }

            // add container
            var $container = $('#notify-container');
            if ($container.length === 0) {
                $container = $('<div></div>').addClass(s.position).prop('id', 'notify-container').prependTo('body');
            }

            // build content
            var $content = $('<p></p>').html(content);
            if (s.icon) {
                var _contentClasses = ['fa', 'fa-'+s.icon, 'fa-'+s.iconPosition];
                $content.addClass(_contentClasses.join(' '));
            }

            // build notif
            var _itemClasses = ['notify', s.type];
            if (s.animationIn) {
                _itemClasses.push('animated', s.animationIn);
            }
            if (s.dismissable) {
                _itemClasses.push('dismissable');

            }
            var $notif = $('<div></div>').addClass(_itemClasses.join(' ')).attr('role', 'alert').append($content);
            if (s.dismissable) {
                $notif.prepend('<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
            }

            // show notif
            $notif.appendTo($container);
            if (typeof s.onShow === 'function') {
                s.onShow();
            }

            // autohide
            if (s.autoHide) {
                window.setTimeout(_hide, s.autoHide);
            }

            // close notif
            function _hide() {
                if (s.animationOut) {
                    $notif.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e) {
                        $notif.remove();
                    });
                    $notif.removeClass(s.animationIn).addClass(s.animationOut);
                } else {
                    $(this).remove();
                }
                if (typeof s.onHide === 'function') {
                    s.onHide();
                }
            }

            if (s.dismissable) {
                $notif.find('.close').on('click touch', _hide);
            }

            return this;
        }
    });
})(jQuery);
;jQuery(document).ready(function($) {

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
















