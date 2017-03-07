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
             * get oauth applications
             * @returns {IPromise<T>}
             */
            getOAuthApplications: function (namesOnly) {
                var defer = $q.defer();
                $http.post(API_PATH + 'oauth/list', {
                    namesOnly: namesOnly || false,
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