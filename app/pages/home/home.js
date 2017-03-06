"use strict";

angular.module('AppHome', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: 'app/pages/home/home.html',
            controller: 'homeController',
        });
    }
]).controller('homeController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    function ($scope, $rootScope, $routeParams) {
        // alert('hey');
    }
]);