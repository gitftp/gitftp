"use strict";

angular.module('ServiceApi', []).factory('Api', [
    '$http',
    '$q',
    'Utils',
    '$rootScope',
    '$ngConfirm',
    function ($http, $q, Utils, $rootScope, $ngConfirm) {
        return {
            /**
             * get oauth connected accounts
             * @returns {IPromise<T>}
             */
            getAvailableBranches: function (repository) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/list_available_branches', {
                    repository: repository
                }).then(function (res) {
                    if (res.data.status) {
                        defer.resolve(res.data.data);
                    } else {
                        defer.reject(res.data.reason);
                    }
                }, function () {
                    defer.reject(API_CONNECTION_ERROR);
                });
                return defer.promise;
            },
            /**
             * get oauth connected accounts
             * @returns {IPromise<T>}
             */
            getAvailableRepositories: function () {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/list_available_repositories', {}).then(function (res) {
                    if (res.data.status) {
                        defer.resolve(res.data.data);
                    } else {
                        defer.reject(res.data.reason);
                    }
                }, function () {
                    defer.reject(API_CONNECTION_ERROR);
                });
                return defer.promise;
            },
            /**
             * get oauth connected accounts
             * @returns {IPromise<T>}
             */
            getConnectedAccounts: function () {
                var defer = $q.defer();
                $http.post(API_PATH + 'accounts/list', {}).then(function (res) {
                    if (res.data.status) {
                        defer.resolve(res.data.data);
                    } else {
                        defer.reject(res.data.reason);
                    }
                }, function () {
                    defer.reject(API_CONNECTION_ERROR);
                });
                return defer.promise;
            },
            /**
             * get oauth applications
             * @returns {IPromise<T>}
             */
            getOAuthApplications: function () {
                var defer = $q.defer();
                $http.post(API_PATH + 'oauth/list', {}).then(function (res) {
                    if (res.data.status) {
                        defer.resolve(res.data.data);
                    } else {
                        defer.reject(res.data.reason);
                    }
                }, function () {
                    defer.reject(API_CONNECTION_ERROR);
                });
                return defer.promise;
            },
            /**
             * set oauth applications
             * @param applications
             * @returns {IPromise<T>}
             */
            saveOAuthApplications: function (applications) {
                var defer = $q.defer();
                $http.post(API_PATH + 'oauth/save', {
                    github: applications.github || null,
                    bitbucket: applications.bitbucket || null,
                }).then(function (res) {
                    if (res.data.status) {
                        defer.resolve(res.data.data);
                    } else {
                        defer.reject(res.data.reason);
                    }
                }, function () {
                    defer.reject(API_CONNECTION_ERROR);
                });
                return defer.promise;
            }
        };
    }
]);