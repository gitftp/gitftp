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
    }
]);