/* Loading
 *
 * Create a loading bar inside the container
---------------------------------------------- */

;(function ( $, window, document, undefined ) {

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





