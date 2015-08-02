module.exports = function(grunt) {

    /**************************************************************************
     * Project configuration
     *************************************************************************/
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        less: {
            development: {
                files: {
                    'style.css': 'style.less'
                }
            }
        },

        watch: {
            css: {
                files: '**/*.less',
                tasks: ['default'],
                options: {
                    interrupt: true
                }
            }
        }

    });

    /**************************************************************************
     * Load task
     *************************************************************************/
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');

    /**************************************************************************
     * Create command
     *************************************************************************/
    grunt.registerTask('default', ['less']);
};