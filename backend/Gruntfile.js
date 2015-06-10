module.exports = function(grunt) {

    // Load grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    // Time how long tasks take. Can help when optimizing build times
    require('time-grunt')(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
    
        less: {
            dev: {
                options: {
                    paths: ["bower_components"]
                },
                files: {
                    "public/css/abclandia-bootstrap.css": "public/css/abclandia-bootstrap.less"
                }
            }
        },
        
        uglify: {
            generated: {
                files: [
                    {
                        dest: 'dist/public/js/abclandia.js',
                        src: ['.tmp/concat/js/abclandia.js']
                    }
                ]
            }
        },
        
        cssmin: {
            generated: {
                files: {
                    'dist/public/css/abclandia.css': ['.tmp/concat/css/abclandia.css']
                }
            }       
        },
        
        processhtml: {
            options: {
                customBlockTypes: ['Gruntblocks.js'],
                config: grunt.config,
                concat: grunt.concat,
                so: 'linux'
            },
            dist: {
                files: [
                    {'dist/app/views/layouts/master.blade.php': ['dist/app/views/layouts/master.blade.php']},
                    {'dist/app/views/layouts/guest.blade.php': ['dist/app/views/layouts/guest.blade.php']},
                    {'dist/app/models/Palabra.php': ['dist/app/models/Palabra.php']}
                ]
            }
        },
        
        copy: {
            dist: {
                files: [
                    {
                        expand: true,
                        src: ['app/**', 'bootstrap/**', 'public/img/**', 'public/fonts/**', 'vendor/**', '!**.git*'],
                        dest: 'dist/'
                    },
                    {
                        expand: false,
                        src: ['public/index.php'],
                        dest: 'dist/'
                    }
                ]
            }
        },
        
        clean: {
            dist: ["dist"],
            postdist: [
                "dist/app/storage/cache/*",
                "dist/app/storage/logs/*",
                "dist/app/storage/sessions/*",
                "dist/app/storage/views/*",
                "dist/app/tests",
                "dist/app/exec/*",
                "dist/app/config/database.php"
            ]
        }
        
    });
    
    grunt.registerTask('build', [
        'clean:dist',
        'copy:dist',
        'clean:postdist',
        'processhtml:dist',
        'concat:js',
        'concat:css',
        'cssmin:generated',
        'uglify:generated'
    ]);
    
};