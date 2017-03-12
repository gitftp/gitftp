"use strict";

var API_CONNECTION_ERROR = 'Connection could not be established';

$script([
    'app/directives/ui.js',
    'app/filters/filters.js',
    'app/services/utils.js',
    'app/services/auth.js',
    'app/services/service.js',
    'app/pages/home/home.js',
    'app/pages/project/new.js',
    'app/pages/project/view.js',
    'app/pages/project/server/add.js',
    'app/pages/project/server/view.js',
    'app/pages/settings/settings.js',
    'app/app.js'
], function () {
    angular.bootstrap(document, ['App']);
});