/* ======================================================
*  Extend
*  =====================================================*/

(function ($) {

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
