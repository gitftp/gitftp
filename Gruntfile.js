module.exports = function (grunt) {
    grunt.initConfig({
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
        },
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.registerTask('build-vendors', ['concat:vendor']);
};