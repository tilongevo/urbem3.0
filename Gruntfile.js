module.exports = function (grunt) {
    'use strict';

    grunt.initConfig({
        package: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                compress: true,
                sourceMap: false,
                mangle: false
            },
            target: {
                files: {
                    '<%= package.bundles.recursos_humanos %>/public/js/recursosHumanos.min.js': ['<%= package.bundles.recursos_humanos %>/public/js/src/**/*.js']
                }
            }
        },

        watch: {
            js: {
                files: './src/Urbem/**/Resources/public/js/src/**/*.js',
                tasks: ['uglify']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['uglify', 'watch']);
}
