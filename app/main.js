"use strict";

$script([
    'app/directives/ui.js',
    // 'app/services/auth.js',
    'app/services/utils.js',
    'app/services/service.js',
    'app/controllers/home.js',
    'app/app.js'
], function () {
    angular.bootstrap(document, ['App']);
});