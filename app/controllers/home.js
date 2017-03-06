"use strict";

angular.module('AppHome', [
    'ngRoute',
    // 'ngAnimate',
    // 'ui.bootstrap',
    // 'Service.utils',
    // 'ngSanitize',
    // 'ngStorage',
    // 'Service.service',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: 'app/templates/home.html',
            controller: 'homeController',
        });
    }
]).controller('homeController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    function ($scope, $rootScope, $routeParams) {
        alert('hey');
    }
]);