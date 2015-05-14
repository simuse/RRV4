/*
 * Project's Gruntfile
 *
 * Available tasks:
 * ----------------
 * - clean         delete files in dist folder
 * - copy          copy files to dist folder
 * - imagemin      minify images in src/img to dist/img
 * - less          compile LESS files
 * - csslint       validate CSS files
 * - csso          minify CSS
 * - concat        concatenate JS
 * - jshint        validate JS
 * - uglify        minify JS
 * - php           start a PHP server
 * - browserSync   synchronise browser on file change
 * - watch         execute set tasks on filechange
 * - plato         generate complexity analysis reports with plato
 * - yuidoc        generate JS documentation
 * - bump          bump project version
 *
 * Bundled tasks:
 * --------------
 * - css           less, csso
 * - js            jshint, concat, uglify
 * - img           imagemin
 * - reports       plato, open:reports
 * - doc           yuidoc, open:doc
 * - serve         php:server, browserSync, watch
 * - prod/build    clean, bump, copy, images, css, js, doc, reports
 *
 * @TODO optimize with grunt-newer & grunt-extend-config
 * @TODO fix bump task
 */

module.exports = function (grunt) {

    'use strict';

    var userConfig = require('./Gruntconfig.js');

    var taskConfig = {

        pkg: grunt.file.readJSON('package.json'),

        meta: {

            banner:
                '/**\n' +
                ' * <%= pkg.name %> - <%= pkg.description %> - v<%= pkg.version %>\n' +
                ' * <%= pkg.homepage %>\n' +
                ' *\n' +
                ' * Author: <%= pkg.author %>\n' +
                ' * License: <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
                ' * Updated: <%= grunt.template.today("dd-mm-yyyy") %>\n' +
                ' */\n'

        }, // meta

        clean: {

            assets: [
                '<%= dir.dist %>/css/*.css',
                '<%= dir.dist %>/js/*.js',
                '<%= dir.dist %>/js/*.map',
                '<%= dir.dist %>/fonts/*',
                '!<%= dir.dist %>/js/*.min.js',
            ],

        }, // clean

        copy: {

            main: {
                files: '<%= files.copy %>',
            }

        }, // copy

        imagemin: {

            options: {
                optimizationLevel: 5
            },

            app: {
                files: [{
                    expand: true,
                    cwd: '<%= dir.src %>/img/',
                    src: '**/*.{png,jpg,gif,svg}',
                    dest: '<%= dir.dist %>/img',
                }]
            },

        }, // imagemin

        less: {

            dev: {
                options: {
                    banner: '<%= meta.banner %>',
                    compress: false,
                    relativeUrls: false,
                    sourceMap: true,
                    sourceMapFileInline: true,
                    strictImports: true,
                    strictMath: true,
                },
                files: {
                    '<%= dir.dist %>/css/main.css': ['<%= dir.src %>/less/main.less'],
                }
            }

        }, // less

        csslint: {

            options: {
                csslintrc: '<%= dir.src %>/.csslintrc'
            },

            files: [
                '<%= dir.dist %>/css/main.min.css',
            ],

        }, // csslint

        csso: {

            options: {
                banner: '<%= meta.banner %>',
            },

            target: {
                files: {
                    '<%= dir.dist %>/css/main.min.css': '<%= dir.dist %>/css/main.css'
                }
            }

        }, // csso

        concat: {
            options: {
                banner: '<%= meta.banner %>',
                separator: ';',
                stripBanners: true,
            },

            plugins: {
                src: ['<%= files.js.plugins %>'],
                dest: '<%= dir.dist %>/js/plugins.js',
            },

            main: {
                src: ['<%= files.js.app %>'],
                dest: '<%= dir.dist %>/js/main.js',
            },

        }, // concat

        jshint: {

            main: {
                src: ['<%= files.js.app %>'],
                options: {
                    jshintrc: true
                }
            },

        }, // jshint

        uglify: {

            options: {
                banner: '<%= meta.banner %>',
                separator: ';',
                stripBanners: true,
            },

            plugins: {
                src: ['<%= files.js.plugins %>'],
                dest: '<%= dir.dist %>/js/plugins.min.js',
            },

            main: {
                src: ['<%= files.js.app %>'],
                dest: '<%= dir.dist %>/js/main.min.js',
            },

        }, // uglify

        php: {

            dev: {
                options: {
                    base: '<%= server.base %>',
                    hostname: '<%= server.hostname %>',
                    port: '<%= server.port %>',
                }
            }

        }, // php

        browserSync: {

            dev: {
                bsFiles: {
                    src: [
                        '<%= dir.dist %>/css/**/*.css',
                        '<%= dir.dist %>/js/**/*.js',
                        '<%= dir.views %>/**/*.php',
                    ]
                },
                options: {
                    proxy: '<%= server.hostname %>:<%= server.port %>',
                    port: 8080,
                    open: true,
                    watchTask: true,
                }
            }

        }, // browserSync

        watch: {

            views: {
                files: '<%= dir.views %>',
                tasks: ['shell:clear', 'notify:watch'],
            },

            less: {
                files: '<%= dir.src %>/less/**/*.less',
                tasks: ['shell:clear', 'notify:watch', 'less:dev', 'notify:css'],
            },

            js: {
                files: '<%= dir.src %>/js/**/*.js',
                tasks: ['shell:clear', 'notify:watch', 'concat', 'notify:js'],
            },

        }, // watch

        concurrent: {

            assets: {
                tasks: ['js', 'css'],
            },

            docs: {
                tasks: ['doc', 'reports'],
            },

            files: {
                tasks: ['copy', 'img'],
            }

        }, // concurrent

        notify: {

            watch: {
                options: {
                    title: 'ᕕ( ᐛ )ᕗ',
                    message: 'File changed',
                }
            },

            js: {
                options: {
                    title: '( ღ’ᴗ’ღ )',
                    message: 'JS files compiled',
                }
            },

            css: {
                options: {
                    title: 'ლ(╹◡╹ლ)',
                    message: 'CSS files compiled ',
                }
            },

            img: {
                options: {
                    title: '(︶.̮︶✽)',
                    message: 'Images optimized',
                }
            },

            serve: {
                options: {
                    title: '☜(⌒▽⌒)☞',
                    message: 'Server ready',
                }
            },

            dev: {
                options: {
                    title: '☆(◒‿◒)☆',
                    message: 'Dev task complete !',
                }
            },

            prod: {
                options: {
                    title: 'Prod task complete',
                    message: 'Ready for deployment',
                }
            },

        }, // notify

        shell: {

            clear: {
                command: 'clear'
            }

        }, // shell

        plato: {

            options: {
                jshint: false
            },

            files: {
                src: [
                    '<%= dir.src %>/js/**/*.js',
                ],
                dest: '<%= dir.reports %>',
            },

        }, // plato

        yuidoc: {

            compile: {
                name: '<%= pkg.name %>',
                description: '<%= pkg.description %>',
                version: '<%= pkg.version %>',
                url: '<%= pkg.homepage %>',

                options: {
                    paths: '<%= dir.src %>/js/',
                    outdir: '<%= dir.docs %>/',
                },
            },

        }, // yuidoc

        open: {

            reports: {
                path: '<%= dir.reports %>/index.html',
                app: 'Google Chrome',
            },

            docs: {
                path: '<%= dir.docs %>/index.html',
                app: 'Google Chrome',
            }

        }, //open

        bump: {

            options: {
                files: ['package.json'],
                commit: true,
                commitMessage: 'v%VERSION%',
                commitFiles: ['-a'],

            }

        }, // bump

    };

    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    grunt.initConfig(grunt.util._.extend(taskConfig, userConfig));

    /* ======================================================
    *  Tasks registration
    *  =====================================================*/

    grunt.registerTask('css', [ 'less', 'csso', 'notify:css' ]);

    grunt.registerTask('js', [ 'jshint', 'concat', 'uglify', 'notify:js' ]);

    grunt.registerTask('img', [ 'imagemin', 'notify:img' ]);

    grunt.registerTask('reports', [ 'plato', 'open:reports' ]);

    grunt.registerTask('docs', [ 'yuidoc', 'open:docs' ]);

    grunt.registerTask('serve', [ 'php', 'browserSync', 'watch', 'notify:serve' ]);

    grunt.registerTask('default', [
        'concurrent:files',
        'concurrent:assets',
        'notify:dev',
    ]);

    grunt.registerTask('prod', [
        'clean:dist',
        'bump',
        'concurrent:files',
        'concurrent:assets',
        'concurrent:docs',
        'notify:prod',
    ]);

    grunt.registerTask('build', ['prod']);

};






























