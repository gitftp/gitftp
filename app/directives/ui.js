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
    function ($rootScope, Auth, Utils, $window) {
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
                }
            }
        }
    }
]).directive('projectSidebar', [
    '$rootScope',
    'Auth',
    'Utils',
    '$window',
    '$routeParams',
    function ($rootScope, Auth, Utils, $window, $routeParams) {
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
            }
        }
    }
])