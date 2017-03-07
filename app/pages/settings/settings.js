"use strict";

angular.module('AppSettings', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/settings', {
            templateUrl: 'app/pages/settings/settings.html',
            controller: 'settingsController',
        });
    }
]).controller('settingsController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    function ($scope, $rootScope, $routeParams) {
        // alert('hey');
    }
]);