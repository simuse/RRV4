/* Custom notification plugin
 * call with $.notify('Message to be displayed', optionObject);
---------------------------------------------- */
(function ($) {
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
