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

        $scope.projects_array = [];
        $scope.parseProjects = function () {
            $scope.projects_array = [];
            angular.forEach($rootScope.projects, function (a) {
                $scope.projects_array.push(a);
            });
        };
        $scope.parseProjects();
        $scope.$on('projectsUpdated', $scope.parseProjects);
    }
]);