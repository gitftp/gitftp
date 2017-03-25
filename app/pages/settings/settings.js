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
        }).when('/settings/connected-accounts', {
            templateUrl: 'app/pages/settings/pages/connected-accounts.html',
            controller: 'connectedAccountsController',
            reloadOnSearch: false,
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
                page: '=',
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
    'Utils',
    function ($scope, $rootScope, $routeParams, Utils) {
        Utils.setTitle('Account settings');

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'Account'
            }
        ]);
    }
]).controller('usersController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    function ($scope, $rootScope, $routeParams, Utils) {
        Utils.setTitle('Users');

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'Users'
            }
        ]);
    }
]).controller('oAuthController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    function ($scope, $rootScope, $routeParams, Utils, Api) {
        Utils.setTitle('oAuth applications');

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'OAuth applications'
            }
        ]);

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
]).controller('connectedAccountsController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    '$window',
    '$location',
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $location) {
        Utils.setTitle('Connected accounts');

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'Connected accounts'
            }
        ]);

        $scope.availableApps = {};
        $scope.connected = [];

        if ($routeParams.s) {
            console.log($routeParams);
            if ($routeParams.s == 'failure') {
                var m = $routeParams.e;
                if (m == 0)
                    m = 'Could not connect to the provider';

                Utils.error(m, 'red');
            }
            $location.search('s', null).search('e', null);
        }

        $scope.load = function () {
            $scope.loading = true;

            // get only names of the oauth applications available.
            Api.getConnectedAccounts().then(function (data) {
                $scope.availableApps.github = data.providers.github || false;
                $scope.availableApps.bitbucket = data.providers.bitbucket || false;
                $scope.connected = data.connected;
                angular.forEach($scope.connected, function (co) {
                    if (co.provider == 'github')
                        $scope.availableApps.github = false;
                    if (co.provider == 'bitbucket')
                        $scope.availableApps.bitbucket = false;
                });

                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };

        $scope.load();

        $scope.connect = function (provider) {
            if (provider == 'github') {
                $window.location.href = GITHUB_CALLBACK;
            } else if (provider == 'bitbucket') {
                $window.location.href = BITBUCKET_CALLBACK;
            } else {
                return false;
            }
        }
    }
]);