"use strict";

angular.module('AppHome', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: 'app/pages/home/home.html',
            controller: 'homeController',
        }).when('/home', {
            templateUrl: 'app/pages/home/home.html',
            controller: 'homeController',
        });
    }
]).controller('homeController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    function ($scope, $rootScope, $routeParams, Utils) {
        Utils.setTitle('Home');

    }
]);