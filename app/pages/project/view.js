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
    function ($scope, $rootScope, $routeParams, Utils, Api, Const) {
        Utils.setTitle($routeParams.name);
        $scope.id = $routeParams.id;
        $scope.project = {};
        $scope.records = [];
        $scope.loadingRecords = false;
        $scope.totalRecords = 0;
        $scope.loading = false;

        angular.forEach($rootScope.projects, function (v) {
            if (v.id == $scope.id) {
                $scope.project = v;
            }
        });

        $scope.isCloned = $scope.project.clone_state == Const.clone_state_cloned;

        $scope.load = function () {
            $scope.loading = true;
            Api.getSingleProject($scope.id).then(function (data) {
                $scope.project = data;
                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };

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

        $scope.startCloning = function () {
            Api.startProjectCloning($scope.id).then(function () {
                $scope.loadRecords();
            }, function (reason) {
                Utils.error(reason, 'red');
            })
        };

        $scope.load();
        $scope.loadRecords();
    }
]);