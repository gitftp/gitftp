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
    'Api',
    '$timeout',
    function ($scope, $rootScope, $routeParams, Utils, Api, $timeout) {
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

        $scope.passChange = {};
        $scope.passError = false;
        $scope.passLoading = false;
        $scope.passSuccess = false;
        $scope.changePassword = function () {
            $scope.passError = false;
            $scope.passLoading = true;
            $scope.passSuccess = false;
            Api.updatePassword($scope.passChange.oldPass, $scope.passChange.newPass).then(function (data) {
                $scope.passLoading = false;
                $scope.passSuccess = true;
                $scope.passChange.oldPass = '';
                $scope.passChange.newPass = '';
                $timeout(function () {
                    $scope.passSuccess = false;
                }, 3000);
            }, function (reason) {
                $scope.passLoading = false;
                $scope.passError = reason;
                $scope.passSuccess = false;
            })
        };
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

            Utils.notification('Loading...');
            Api.saveOAuthApplications(settings).then(function () {
                $scope.saving = false;
                Utils.notification('Saved', 'green');
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
    '$ngConfirm',
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $location, $ngConfirm) {
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

        $scope.availableApps = {
            github: {
                available: false,
                connected: false,
            },
            bitbucket: {
                available: false,
                connected: false,
            },
        };

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
                $scope.connected = data.connected;
                angular.forEach($scope.connected, function (co) {
                    if (co.provider == 'github')
                        $scope.availableApps.github.connected = true;
                    if (co.provider == 'bitbucket')
                        $scope.availableApps.bitbucket.connected = true;
                });

                $scope.availableApps.github.available = angular.isDefined(data.providers.github);
                $scope.availableApps.bitbucket.available = angular.isDefined(data.providers.bitbucket);

                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };

        $scope.load();

        $scope.connect = function (provider) {
            if (!$scope.availableApps[provider].available || $scope.availableApps[provider].connected) {
                return false;
            }

            if (provider == 'github') {
                $window.location.href = GITHUB_CALLBACK;
            } else if (provider == 'bitbucket') {
                $window.location.href = BITBUCKET_CALLBACK;
            } else {
                return false;
            }
        };

        $scope.disconnect = function (id, provider) {
            $ngConfirm({
                title: 'Disconnect from ' + provider + '?',
                content: '<p>' +
                'Are you sure to disconnect from the provider {{provider}}? <br>' +
                '</p>' +
                '<p>The following projects will stop working:</p>' +
                '<div ng-if="affectedProjects.length">' +
                '<div ng-repeat="a in affectedProjects">' +
                '{{a}}' +
                '</div>' +
                '</div>' +
                '<div ng-if="!affectedProjects.length" class="text-muted">' +
                'Found no projects from {{provider}}' +
                '</div>',
                onScopeReady: function (scope) {
                    scope.provider = provider;
                    scope.affectedProjects = [];
                    angular.forEach($scope.projects, function (a) {
                        if (a.provider == provider)
                            scope.affectedProjects.push(a.name);
                    });
                },
                buttons: {
                    disconnect: {
                        btnClass: 'btn-red',
                        action: function (scope, button) {
                            var self = this;
                            button.setText('please wait');
                            button.setDisabled(true);
                            Api.disconnectConnectedAccounts(id).then(function () {
                                Utils.notification('Successfully removed provider ' + provider, 'green');
                                self.close();
                                $scope.load();
                            }, function () {
                                button.setText('disconnect');
                                button.setDisabled(false);
                            });
                            return false;
                        }
                    },
                    close: function () {

                    }
                }
            });
        };
    }
]);