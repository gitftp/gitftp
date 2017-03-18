"use strict";

angular.module('ServiceAuth', []).factory('Auth', [
    '$http',
    '$q',
    'Utils',
    '$rootScope',
    '$ngConfirm',
    function ($http, $q, Utils, $rootScope, $ngConfirm) {
        var Auth = {};
        Auth.isAuthenticated = function () {
            return Object.keys($rootScope.user).length > 0;
        };
        Auth.logout = function () {
            var defer = $q.defer();
            $http.get(API_PATH + 'auth/logout').then(function (res) {
                if (res.data.status) {
                    $rootScope.user = {};
                    $rootScope.$broadcast('user-logout');
                    defer.resolve(res.data);
                } else {
                    defer.reject(res.data.reason);
                }
            }, function () {
                defer.reject(API_CONNECTION_ERROR);
            });
            return defer.promise;
        };
        return Auth;
    }
]);