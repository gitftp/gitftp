"use strict";

angular.module('ServiceAuth', []).factory('Auth', [
    '$http',
    '$q',
    'Utils',
    '$rootScope',
    '$ngConfirm',
    function ($http, $q, Utils, $rootScope, $ngConfirm) {
        var Auth = {};
        // Auth.login = function (creds) {
        //     return $q(function (resolve, reject) {
        //         $http.post('api/auth/login', creds).then(function (res) {
        //             if (res.data.status) {
        //                 $rootScope.user = res.data.user;
        //                 $rootScope.cartL = res.data.cart;
        //                 $rootScope.w_balance = res.data.w_balance;
        //                 $rootScope.c_balance = res.data.c_balance;
        //                 $rootScope.c_balance_f = res.data.c_balance_f;
        //                 $rootScope.$broadcast('user-login');
        //                 resolve(res);
        //             } else {
        //                 reject(res);
        //             }
        //         });
        //     });
        // };
        // Auth.updateUser = function (callback) {
        //     $http.get(API_PATH + 'auth/user').then(function (res) {
        //         if (res.data.status) {
        //             $rootScope.cartL = res.data.cart;
        //             $rootScope.user = res.data.user;
        //             $rootScope.w_balance = res.data.w_balance;
        //             $rootScope.c_balance = res.data.c_balance;
        //             $rootScope.c_balance_f = res.data.c_balance_f;
        //             $rootScope.$broadcast('user-login');
        //         }
        //         (callback || angular.noop)(res);
        //     }, function () {
        //         $ngConfirm('Something went wrong, please refresh the page.');
        //     });
        // };
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
        // Auth.forgotpassword = function (creds) {
        //     return $q(function (resolve, reject) {
        //         $http.post('api/auth/forgotpassword', creds).then(function (res) {
        //             if (res.data.status) {
        //                 resolve(res);
        //             } else {
        //                 reject(res);
        //             }
        //         });
        //     });
        // };
        return Auth;
    }
]);