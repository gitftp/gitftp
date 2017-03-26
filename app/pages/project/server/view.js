"use strict";

angular.module('AppProjectServerView', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/server/:server_id', {
            templateUrl: 'app/pages/project/server/view.html',
            controller: 'viewProjectServerController',
        });
    }
]).controller('viewProjectServerController', [
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
        $scope.server_id = $routeParams.server_id;
        var server = {};
        angular.forEach($scope.projects[$scope.id].servers, function (s) {
            if (s.id == $scope.server_id)
                server = s;
        });
        $scope.server = server;

        Utils.setTitle($scope.server.name);

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "view/" + $scope.project.id + "/" + $scope.project.name,
                name: $scope.project.name
            },
            {
                link: "",
                name: $scope.server.name
            },
            {
                link: "",
                name: "Deploy activity"
            }
        ]);

        $scope.records = [];
        $scope.loadingRecords = false;
        $scope.totalRecords = 0;
        $scope.loading = false;

        $scope.page = 'view-server';

        $scope.$on('projectsUpdated', function () {
            console.log('projectsUpdated');
            $scope.project = $rootScope.projects[$scope.id];
        });

        $scope.loadRecords = function () {
            $scope.loadingRecords = true;
            Api.getRecords($scope.id, $scope.server_id).then(function (records) {
                $scope.records = records.list;
                $scope.totalRecords = records.total;
                $scope.loadingRecords = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.loadRecords);
                $scope.loadingRecords = false;
            })
        };

        var loaded = true;
        $scope.checkForNewRecords = function () {
            if (!loaded)
                return false;

            console.log('checkForNewRecords');
            if (!$scope.records.length) {
                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
                return false;
            }

            Api.getLatestRecords($scope.id, $scope.records[0].id, $scope.server_id).then(function (data) {
                if (data.list.length) {
                    $scope.records = data.list.concat($scope.records);
                }

                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
            }, function (reason) {
                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
            });
        };

        $scope.checkForNewRecords();

        $scope.$on('$destroy', function () {
            loaded = false;
        });

        $scope.loadRecords();

    }
]);