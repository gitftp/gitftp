"use strict";

angular.module('AppSettings', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/settings', {
            templateUrl: 'app/pages/settings/pages/settings.html',
            controller: 'accountSettingsController',
        }).when('/settings/users', {
            templateUrl: 'app/pages/settings/pages/users.html',
            controller: 'usersController',
        }).when('/settings/oauth-applications', {
            templateUrl: 'app/pages/settings/pages/oauth-applications.html',
            controller: 'oAuthController',
        });
    }
]).directive('settingsSidebar', [
    '$rootScope',
    '$location',
    function ($rootScope, $location) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/pages/settings/sidebar.html',
            scope: {
                page: '='
            },
            link: function (scope, element) {
                scope.currentPage = $location.path();
                scope.isCurrent = function (path) {
                    return path == scope.currentPage;
                }
            }
        }
    }
]).controller('accountSettingsController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    function ($scope, $rootScope, $routeParams) {

    }
]).controller('usersController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    function ($scope, $rootScope, $routeParams) {

    }
]).controller('oAuthController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    function ($scope, $rootScope, $routeParams, Utils, Api) {
        Utils.setTitle('oAuth applications');

        $scope.settings = {};
        $scope.oauth = {};
        $scope.oauth.isGithub = true;
        $scope.oauth.isBitbucket = true;

        $scope.load = function () {
            $scope.loading = true;
            Api.getOAuthApplications().then(function (data) {
                $scope.settings.github = data.github || {};
                $scope.settings.bitbucket = data.bitbucket || {};
                if (data.bitbucket) {
                    $scope.oauth.isBitbucket = true;
                } else {
                    $scope.oauth.isBitbucket = false;
                }
                if (data.github) {
                    $scope.oauth.isGithub = true;
                } else {
                    $scope.oauth.isGithub = false;
                }

                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };

        $scope.saving = false;
        $scope.save = function () {
            $scope.saving = true;
            var settings = {};
            if ($scope.oauth.isGithub)
                settings.github = $scope.settings.github;
            if ($scope.oauth.isBitbucket)
                settings.bitbucket = $scope.settings.bitbucket;

            Api.saveOAuthApplications(settings).then(function () {
                $scope.saving = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.save);
                $scope.saving = false;
            });
        };
        $scope.load();
    }
]);