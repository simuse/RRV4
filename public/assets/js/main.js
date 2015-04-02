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
















