"use strict";

angular.module('Service.auth', []).factory('AuthService', [
    '$http',
    '$q',
    'Utils',
    '$rootScope',
    '$ngConfirm',
    function ($http, $q, Utils, $rootScope, $ngConfirm) {
        var Auth = {};
        Auth.login = function (creds) {
            return $q(function (resolve, reject) {
                $http.post('api/auth/login', creds).then(function (res) {
                    if (res.data.status) {
                        $rootScope.user = res.data.user;
                        $rootScope.cartL = res.data.cart;
                        $rootScope.w_balance = res.data.w_balance;
                        $rootScope.c_balance = res.data.c_balance;
                        $rootScope.c_balance_f = res.data.c_balance_f;
                        $rootScope.$broadcast('user-login');
                        resolve(res);
                    } else {
                        reject(res);
                    }
                });
            });
        };
        Auth.updateUser = function (callback) {
            $http.get('api/auth/user').then(function (res) {
                if (res.data.status) {
                    $rootScope.cartL = res.data.cart;
                    $rootScope.user = res.data.user;
                    $rootScope.w_balance = res.data.w_balance;
                    $rootScope.c_balance = res.data.c_balance;
                    $rootScope.c_balance_f = res.data.c_balance_f;
                    $rootScope.$broadcast('user-login');
                }
                (callback || angular.noop)(res);
            }, function () {
                $ngConfirm('Something went wrong, please refresh the page.');
            });
        };
        Auth.isAuthenticated = function () {
            return Object.keys($rootScope.user).length > 0;
        };
        Auth.resend_signup_otp = function (token) {
            return $q(function (res, rej) {
                $http.post(home_url + 'api/auth/ca_otp', {
                    token: token,
                }).then(function (r) {
                    (r.data.status) ? res(r) : rej(r);
                }, function () {
                    rej('Network problem');
                });
            });
        };
        Auth.resend_signup_email = function (user_id) {
            return $q(function (res, rej) {
                $http.post(home_url + 'api/auth/ca_email', {
                    id: user_id,
                }).then(function (r) {
                    (r.data.status) ? res(r) : rej(r.data.reason);
                }, function () {
                    rej('Network problem');
                });
            });
        };
        Auth.signup = function (creds) {
            return $q(function (resolve, reject) {
                $http.post(home_url + 'api/auth/signup', creds).then(function (res) {
                    if (res.data.status) {
                        resolve(res);
                        if (res.data.user) {
                            $rootScope.user = res.data.user;
                            $rootScope.cartL = res.data.cart;
                            $rootScope.w_balance = res.data.w_balance;
                            $rootScope.c_balance = res.data.c_balance;
                            $rootScope.c_balance_f = res.data.c_balance_f;
                            $rootScope.$broadcast('user-login');
                        }
                    } else {
                        reject(res);
                    }
                }, function () {
                    reject('Network problem');
                });
            });
        };
        Auth.logout = function () {
            return $q(function (resolve, reject) {
                $http.get(home_url + 'api/auth/logout').then(function (res) {
                    if (res.data.status) {
                        $rootScope.user = {};
                        $rootScope.cartL = {};
                        $rootScope.w_balance = false;
                        $rootScope.c_balance = false;
                        $rootScope.c_balance_f = false;
                        $rootScope.$broadcast('user-logout');
                        resolve(res);
                    } else {
                        reject(res);
                    }
                });
            });
        };
        Auth.forgotpassword = function (creds) {
            return $q(function (resolve, reject) {
                $http.post('api/auth/forgotpassword', creds).then(function (res) {
                    if (res.data.status) {
                        resolve(res);
                    } else {
                        reject(res);
                    }
                });
            });
        };
        return Auth;
    }
]);