/**
 * Grunt configuration
 */

module.exports = {

    /**
     * Paths
     */
    dir: {

        root:       'public',
        dist:       'public/assets',
        src:        'resources/assets',
        pkg:        'resources/assets/bower_components',
        docs:       'resources/docs',
        reports:    'resources/reports',
        views:      'resources/views',

    },

    /**
     * Server configuration
     */
    server: {

        base:           'public',
        hostname:       '127.0.0.1',
        port:           8010,
        livereload:     false,
        watch:          false,

    },

    /**
     * Files to watch
     */
    // watch: {

    //     less:   '<%= dir.src %>/less/**/*.less',
    //     js:     '<%= dir.src %>/js/**/*.js',
    //     php:    ['<%= dir.views %>/**/*.php']

    // },

    files: {

        /**
         * Files to copy from one folder to another
         */
        copy: [
            {
                src: ['<%= dir.pkg %>/font-awesome/fonts/*'],
                dest: '<%= dir.dist %>/fonts/',
                expand: true, flatten: true
            },
            {
                src: ['<%= dir.pkg %>/fancybox/source/*{png,gif}'],
                dest: '<%= dir.dist %>/css/',
                expand: true, flatten: true
            },
            {
                src: [
                    '<%= dir.pkg %>/jquery/dist/jquery.min.js',
                    '<%= dir.pkg %>/jquery/dist/jquery.min.map'
                ],
                dest: '<%= dir.dist %>/js/',
                expand: true, flatten: true
            }
        ],

        js: {

            app: [

                '<%= dir.src %>/js/helpers.js',
                '<%= dir.src %>/js/extend.js',
                '<%= dir.src %>/js/modules/*.js',
                '<%= dir.src %>/js/main.js',

            ],

            plugins: [

                '<%= dir.pkg %>/Semantic-UI/dist/semantic.js',
                '<%= dir.pkg %>/fancybox/source/jquery.fancybox.js',
                '<%= dir.pkg %>/isotope/dist/isotope.pkgd.js',
                '<%= dir.pkg %>/unveil/jquery.unveil.js',
                '<%= dir.pkg %>/autocompeter/public/dist/autocompeter.js',
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
                // '<%= dir.pkg %>/imagesloaded/imagesloaded.pkgd.js',
                // '<%= dir.pkg %>/jquery-mousewheel/jquery.mousewheel.js',

            ],

        },

    }

};














