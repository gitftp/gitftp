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

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "view/" + $scope.project.id + "/" + $scope.project.name,
                name: $scope.project.name
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
                $scope.startingCloning = false;
                $scope.loadRecords();
            }, function (reason) {
                $scope.startingCloning = false;
                Utils.notification(reason, 'red');
            });
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

            Api.getLatestRecords($scope.id, $scope.records[0].id).then(function (data) {
                if (data.list.length) {
                    $scope.records = data.list.concat($scope.records);
                    // angular.forEach(data.list, function (rec) {
                    //     $scope.records.unshift(rec);
                    // });
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