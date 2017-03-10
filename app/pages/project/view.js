"use strict";

angular.module('AppProjectView', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name', {
            templateUrl: 'app/pages/project/view.html',
            controller: 'viewProjectController',
        });
    }
]).controller('viewProjectController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    'Const',
    '$timeout',
    '$ngConfirm',
    function ($scope, $rootScope, $routeParams, Utils, Api, Const, $timeout, $ngConfirm) {
        $scope.id = $routeParams.id;
        $scope.project = $rootScope.projects[$scope.id];
        Utils.setTitle($scope.project.name);

        $scope.records = [];
        $scope.loadingRecords = false;
        $scope.totalRecords = 0;
        $scope.loading = false;

        $scope.page = 'view-project';

        $scope.$on('projectsUpdated', function () {
            console.log('projectsUpdated');
            $scope.project = $rootScope.projects[$scope.id];
        });

        $scope.loadRecords = function () {
            $scope.loadingRecords = true;
            Api.getRecords($scope.id).then(function (records) {
                $scope.records = records.list;
                $scope.totalRecords = records.total;
                $scope.loadingRecords = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.loadRecords);
                $scope.loadingRecords = false;
            })
        };

        $scope.startingCloning = false;
        $scope.startCloning = function () {
            $scope.startingCloning = true;
            Api.startProjectCloning($scope.id).then(function () {
            }, function (reason) {
            });
            $timeout(function () {
                $scope.startingCloning = false;
                $scope.loadRecords();
            }, 1000);
        };

        $scope.loadRecords();

        $scope.errorMessage = function (text) {
            $ngConfirm({
                title: 'Failure reason',
                content: "<pre>" + text + "</pre>",
                type: 'red',
            });
        }
    }
]);