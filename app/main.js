"use strict";

var API_CONNECTION_ERROR = 'Connection could not be established';

$script([
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
    'app/pages/project/settings.js',
    'app/pages/settings/settings.js',
    'app/app.js'
], function () {
    angular.bootstrap(document, ['App']);
});