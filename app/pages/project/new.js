"use strict";

angular.module('AppProjectNew', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/project/new', {
            templateUrl: 'app/pages/project/new.html',
            controller: 'createProjectController',
        });
    }
]).controller('createProjectController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    function ($scope, $rootScope, $routeParams, Utils, Api) {
        Utils.setTitle('Create new project');


        $scope.available_repos = [];
        $scope.loading = false;
        $scope.load = function () {
            $scope.loading = true;
            Api.getAvailableRepositories().then(function (data) {
                $scope.available_repos = data;
                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };
        $scope.load();


        $scope.selectedRepo = false;
        $scope.selectRepo = function (repo) {
            $scope.selectedRepo = repo;
        }
    }
]);