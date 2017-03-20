"use strict";

angular.module('AppProjectSettings', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/settings', {
            templateUrl: 'app/pages/project/settings/basic.html',
            controller: 'viewProjectSettingsBasicController',
        });
    }
]).controller('viewProjectSettingsBasicController', [
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
        $scope.project = angular.copy($rootScope.projects[$scope.id]);
        Utils.setTitle($scope.project.name);

        $scope.page = 'project-settings';
        $scope.current = 'project-settings-basic';

        $scope.hookExists = false;
        $scope.hookLoading = false;
        $scope.checkHook = function () {
            $scope.hookLoading = true;
            Api.checkHook($scope.id).then(function (data) {
                $scope.hookLoading = false;
                $scope.hookExists = !!data;
            }, function (reason) {
                $scope.hookLoading = false;
                Utils.notification(reason, 'red');
            })
        };
        $scope.checkHook();

        $scope.creatingHook = false;
        $scope.createHook = function () {
            $scope.creatingHook = true;
            Api.createHook($scope.id).then(function (data) {
                $scope.creatingHook = false;
                $scope.checkHook();
            }, function (reason) {
                $scope.creatingHook = false;
                Utils.notification(reason, 'red');
            })
        };
    }
]);