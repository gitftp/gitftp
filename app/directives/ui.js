"use strict";

angular.module('AppDirectives', [
    'ngAnimate',
    'ServiceAuth',
    'ServiceUtils',
]).directive('topHeader', [
    '$rootScope',
    'Auth',
    'Utils',
    '$window',
    '$routeParams',
    '$location',
    '$timeout',
    'Api',
    function ($rootScope, Auth, Utils, $window, $routeParams, $location, $timeout, Api) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/partials/topHeader.html',
            link: function (scope, element) {
                scope.logout = function () {
                    Auth.logout().then(function (res) {
                        $window.location.reload();
                    }, function (message) {
                        Utils.error(message, 'red');
                    });
                };

                scope.$location = $location;

                scope.showSyncButton = false;
                scope.project = false;
                scope.server_name = false;

                scope.$watch('$location.path()', function () {
                    $timeout(function () {
                        console.log('location changed ');
                        if ($routeParams.id) {
                            scope.showSyncButton = true;
                        } else {
                            scope.showSyncButton = false;
                        }

                        if ($routeParams.id && $rootScope.projects[$routeParams.id]) {
                            scope.project = $rootScope.projects[$routeParams.id];
                        } else {
                            scope.project = false;
                        }

                        if (scope.project && $routeParams.server_id) {
                            angular.forEach(scope.project.servers, function (a) {
                                if (a.id == $routeParams.server_id) {
                                    scope.server_name = a.name;
                                }
                            });
                        } else {
                            scope.server_name = false;
                        }
                    }, 200);
                });

                scope.syncProject = function () {
                    if (!$routeParams.id)
                        return false;

                    Utils.notification('Pulling changes from repository');
                    Api.syncProject($routeParams.id).then(function () {
                        Utils.notification('Successfully pulled changes from repository', 'green');
                    }, function (reason) {
                        Utils.notification('Failed to pull changes: ' + reason, 'red');
                    });
                };
            }
        }
    }
]).directive('projectSidebar', [
    '$rootScope',
    'Auth',
    'Utils',
    '$window',
    '$routeParams',
    '$ngConfirm',
    'Const',
    'Api',
    function ($rootScope, Auth, Utils, $window, $routeParams, $ngConfirm, Const, Api) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/partials/projectSidebar.html',
            scope: {
                page: '=page'
            },
            link: function (scope, element) {
                scope.id = $routeParams.id;
                scope.project = $rootScope.projects[scope.id];

                scope.$on('projectsUpdated', function () {
                    console.log('Directive project update.');
                    scope.project = $rootScope.projects[scope.id];
                });

                scope.serverType = function (state) {
                    return Utils.serverType(state);
                };
            }
        }
    }
])