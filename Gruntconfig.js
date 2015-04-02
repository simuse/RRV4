/**
 * Grunt configuration
 */

module.exports = {

    /**
     * Folders used in Grunt tasks
     * @type {Object}
     */
    dir: {

        root:       'public',
        dist:       'public/assets',
        src:        'resources/assets',
        pkg:        'resources/assets/packages',
        docs:       'resources/docs',
        reports:    'resources/reports',
        views:      'resources/views',

    },

    /**
     * Server configuration
     * @type {Object}
     */
    server: {

        base:           'public',
        hostname:       '127.0.0.1',
        port:           9000,
        livereload:     false,
        watch:          false,

    },

    /**
     * Files to watch
     * @type {Object}
     */
    watch: {

        less:   '<%= dir.src %>/less/**/*.less',
        js:     '<%= dir.src %>/js/**/*.js',
        php:    ['<%= dir.views %>/**/*.php']

    },

    /**
     * Files/Folders to be processed in Grunt tasks
     * @type {Object}
     */
    files: {

        plugins: {

            fonts: [

                'font-awesome/fonts/*',

            ],

            images: [],

            js: [

                // '<%= dir.pkg %>/underscore/underscore.js',
                // '<%= dir.pkg %>/backbone/backbone.js',
                // '<%= dir.pkg %>/console-polyfill/index.js',
                // '<%= dir.pkg %>/bootstrap/js/tooltip.js',
                // '<%= dir.pkg %>/bootstrap/js/affix.js',
                // '<%= dir.pkg %>/bootstrap/js/alert.js',
                // '<%= dir.pkg %>/bootstrap/js/button.js',
                // '<%= dir.pkg %>/bootstrap/js/carousel.js',
                // '<%= dir.pkg %>/bootstrap/js/collapse.js',
                // '<%= dir.pkg %>/bootstrap/js/dropdown.js',
                // '<%= dir.pkg %>/bootstrap/js/modal.js',
                // '<%= dir.pkg %>/bootstrap/js/popover.js',
                // '<%= dir.pkg %>/bootstrap/js/scrollspy.js',
                // '<%= dir.pkg %>/bootstrap/js/tab.js',
                // '<%= dir.pkg %>/bootstrap/js/transition.js',
                // '<%= dir.pkg %>/fancybox/source/jquery.fancybox.js',
                // '<%= dir.pkg %>/isotope/dist/isotope.pkgd.js',
                // '<%= dir.pkg %>/imagesloaded/imagesloaded.pkgd.js',
                // '<%= dir.pkg %>/unveil/jquery.unveil.js',
                // '<%= dir.pkg %>/jquery-mousewheel/jquery.mousewheel.js',
                // '<%= dir.pkg %>/freezeframe/freezeframe.js',
                // '<%= dir.pkg %>/gifplayer/js/jquery.gifplayer.js',
                '<%= dir.pkg %>/Semantic-UI/dist/semantic.js',

            ],

        }, // plugins

        app: {

            js: [

                // '<%= dir.src %>/js/helpers.js',
                // '<%= dir.src %>/js/extend.js',
                // '<%= dir.src %>/js/modules/*.js',
                // '<%= dir.src %>/js/main.js',

            ],

            less: [

                '<%= dir.src %>/less/main.less',

            ],

        }, // app

    }

};














