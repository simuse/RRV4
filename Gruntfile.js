/*
 * Project's Gruntfile
 *
 * Available tasks:
 * ----------------
 * - clean         delete files and folders
 * - copy          copy files to another folder
 * - imagemin      minify images
 * - less          compile LESS files
 * - csslint       validate CSS files
 * - cssmin        minify CSS
 * - concat        concatenate JS
 * - jshint        validate JS
 * - uglify        minify JS
 * - php           start a PHP server
 * - browserSync   synchronise browser on file change
 * - watch         execute set tasks on filechange
 * - plato         generate complexity analysis reports with plato
 * - yuidoc        generate JS documentation
 * - bump          bump project version
 * - wow           increase developer morale
 *
 * Bundled tasks:
 * --------------
 * - css           less:dev, cssmin
 * - js            jshint, concat
 * - img           imagemin
 * - report        plato, open:reports
 * - doc           yuidoc, open:doc
 * - serve         php:server, browserSync, watch
 * - prod/build    clean, copy, images, less:prod, autoprefixer, cssmin, csslint, jshint, uglify, doc, report, bump, notify:prod
 *
 * @TODO improve plato task
 * @TODO improve watch / browsersync synergy
 * @TODO fix serve task
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
                ' * <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
                ' * <%= pkg.homepage %>\n' +
                ' *\n' +
                ' * Copyright 2014-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
                ' * Licensed under <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
                ' */\n'

        }, // meta

        clean: {

            dist: {
                src: [
                    '<%= dir.dist %>/css/*{.css}',
                    '<%= dir.dist %>/js/*{.js}'
                ],
                options: {
                    force: true
                },
            },

        }, // clean

        copy: {

            main: {
                files: '<%= files.copy %>',

                // @todo make options work
                // options: {
                //     expand: true,
                //     flatten: true
                // }

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
            },

            prod: {
                options: {
                    banner: '<%= meta.banner %>',
                    compress: true,
                    relativeUrls: false,
                    strictImports: true,
                    strictMath: true,
                },
                files: {
                    '<%= dir.dist %>/css/main.min.css': ['<%= dir.src %>/less/main.less'],
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

        cssmin: {

            options: {
                advanced: false,
                compatibility: 'ie8',
                debug: true,
                keepSpecialComments: 0,
            },

            target: {
                files: {
                    '<%= dir.dist %>/css/main.min.css': '<%= dir.dist %>/css/main.css'
                }
            },

        }, // cssmin

        concat: {
            options: {
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

            server: {
                options: {
                    base: '<%= server.base %>',
                    hostname: '<%= server.hostname %>',
                    port: '<%= server.port %>',
                    keepalive: true,
                    // open: false,
                }
            }

        }, // php

        browserSync: {

            dist: {
                files: {
                    src: [
                        '<%= dir.dist %>/css/**/*.css',
                        '<%= dir.dist %>/js/**/*.js',
                        '<%= dir.views %>/**/*.php',
                    ]
                },
                options: {
                    proxy: '<%= server.hostname %>:<%= server.port %>',
                    watchTask: true,
                    notify: true,
                    open: true,
                    logLevel: 'silent',
                    ghostMode: false,
                }
            }

        }, // browserSync

        watch: {

            options: {
                livereload: false,
                livereloadOnError: false
            },

            less: {
                files: '<%= dir.src %>/less/**/*.less',
                tasks: [
                    'shell:clear',
                    'notify:watch',
                    'css',
                ]
            },

        }, // watch

        concurrent: {

            assets: {
                tasks: ['js', 'css'],
            },

        }, // concurrent

        notify: {

            js: {
                options: {
                    title: 'JS task complete',
                    message: '...',
                }
            },

            css: {
                options: {
                    title: 'CSS task complete',
                    message: '...',
                }
            },

            img: {
                options: {
                    title: 'IMG task complete',
                    message: '...',
                }
            },

            dev: {
                options: {
                    title: 'DEV task complete',
                    message: 'We are ready for development, master',
                }
            },

            prod: {
                options: {
                    title: 'PROD task complete',
                    message: 'All files ready for production',
                }
            },

            watch: {
                options: {
                    title: 'File change detected',
                    message: 'Reloading',
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
                src: [ '<%= dir.dist %>/js/**/*.js' ],
                dest: '<%= dir.src %>/reports',
            },

        }, // plato

        open: {

            reports: {
                path: '<%= dir.src %>/reports/index.html',
                app: 'Google Chrome',
            },

            doc: {
                path: '<%= dir.src %>/docs/index.html',
                app: 'Google Chrome',
            }

        }, //open

        yuidoc: {

            compile: {
                name: '<%= pkg.name %>',
                description: '<%= pkg.description %>',
                version: '<%= pkg.version %>',
                url: '<%= pkg.homepage %>',

                options: {
                    paths: '<%= dir.src %>/js',
                    outdir: '<%= dir.src %>/docs/',
                },
            },

        }, // yuidoc

        bump: {

            options: {
                files: ['package.json'],
                commit: false,
            }

        }, // bump

    };
    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    grunt.initConfig(grunt.util._.extend(taskConfig, userConfig));

    /* ======================================================
    *  Tasks registration
    *  =====================================================*/

    grunt.registerTask('css', [ 'less:dev', 'cssmin', 'notify:css' ]);

    grunt.registerTask('js', [ 'jshint', 'concat', 'uglify', 'notify:js' ]);

    grunt.registerTask('img', [ 'imagemin', 'notify:img' ]);

    grunt.registerTask('report', [ 'plato', 'open:reports' ]);

    grunt.registerTask('doc', [ 'yuidoc', 'open:doc' ]);

    grunt.registerTask('serve', [ 'php:server', 'browserSync', /*'watch'*/ ]);

    grunt.registerTask('default', [
        'copy',
        'img',
        'concurrent:assets',
        'notify:dev',
    ]);

    grunt.registerTask('prod', [
        'clean:dist',
        'copy',
        'img',
        'less:dev',
        'cssmin',
        'jshint',
        'uglify',
        'doc',
        'report',
        // 'bump',
        'notify:prod',
    ]);

    grunt.registerTask('build', ['prod']);

};






























