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
    '$ngConfirm',
    function ($rootScope, Auth, Utils, $window, $routeParams, $ngConfirm) {
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

                /**
                 * @todo remove this. not in use.
                 * @param server_id
                 */
                scope.deploy = function (server_id) {
                    $ngConfirm({
                        title: 'Deploy',
                        content: '' +
                        '' +
                        '<div class="row">' +
                        '<div class="col-md-4"><a ng-click="deploy(1)">Update</a></div>' +
                        '<div class="col-md-4"><a ng-click="deploy(2)">Reupload</a></div>' +
                        '<div class="col-md-4"><a ng-click="deploy(3)">Revert</a></div>' +
                        '</div>' +
                        '' +
                        ''
                    })
                };
            }
        }
    }
])