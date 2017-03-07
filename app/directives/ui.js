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
            templateUrl: 'app/partials/topheader.html',
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
])