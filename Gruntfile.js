module.exports = function (grunt) {
    grunt.initConfig({
        uglify: {
            app: {
                files: {
                    'app/build.js': ['app/build.js']
                }
            },
            vendor: {
                files: {
                    'assets/js/vendors.min.js': ['assets/js/vendors.js']
                }
            },
        },
        concat: {
            vendor: {
                src: [
                    'bower_components/jquery/dist/jquery.min.js',
                    'bower_components/bootstrap/dist/js/bootstrap.min.js',
                    'bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js',
                    'bower_components/moment/min/moment.min.js',
                    'bower_components/angular/angular.min.js',
                    'bower_components/angular-sanitize/angular-sanitize.min.js',
                    'bower_components/angular-route/angular-route.min.js',
                    'bower_components/angular-animate/angular-animate.min.js',
                    'bower_components/angular-confirm/dist/angular-confirm.min.js',
                    'bower_components/angular-moment/angular-moment.min.js',
                    'bower_components/ngstorage/ngStorage.min.js',
                    'bower_components/angular-bootstrap/ui-bootstrap.min.js',
                    'bower_components/Waves/dist/waves.min.js',
                    'bower_components/script.js/dist/script.min.js',
                ],
                dest: 'assets/js/vendors.js',
            },
            app: {
                src: [
                    'app/directives/ui.js',
                    'app/filters/filters.js',
                    'app/services/utils.js',
                    'app/services/auth.js',
                    'app/services/service.js',
                    'app/services/components.js',
                    'app/pages/home/home.js',
                    'app/pages/project/new.js',
                    'app/pages/project/view.js',
                    'app/pages/project/server/addEdit.js',
                    'app/pages/project/server/deploy.js',
                    'app/pages/project/server/view.js',
                    'app/pages/project/settings/settings.js',
                    'app/pages/settings/settings.js',
                    'app/app.js',
                    'app/main.js'
                ],
                dest: 'app/build.js',
            },
        },
        watch: {
            app: {
                files: ['app/**/*.js', '!app/build.js'],
                tasks: ['concat:app'],
            },
        },
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('build', ['concat:app']);
    grunt.registerTask('build-release', [
        'concat:vendor',
        'concat:app',
        'uglify:app',
        'uglify:vendor'
    ]);

    grunt.registerTask('default', ['watch:app']);
};