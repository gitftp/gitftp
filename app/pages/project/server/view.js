"use strict";

angular.module('AppProjectServerView', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/serveasdasdasr/:server_id', {
            templateUrl: 'app/pages/project/server/add.html',
            controller: 'viewServerController',
        });
    }
]).controller('viewServerController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    '$window',
    '$q',
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $q) {
        Utils.setTitle('Server');
        $scope.project_id = $routeParams.id;
        $scope.server_id = $routeParams.server_id;
        $scope.page = 'view-server';

        $scope.server = {
            type: 1,
            port: 21,
            secure: true,
        };

        $scope.typeChange = function () {
            if (angular.isDefined($scope.form.port)) {
                if ($scope.form.port.$pristine) {
                    if ($scope.server.type == 1)
                        $scope.server.port = 21;
                    else if ($scope.server.type == 2)
                        $scope.server.port = 22;
                }
            }
        };

        $scope.saving = false;
        $scope.newServer = function () {
            $scope.saving = true;
            $scope.testConnection().then(function () {
                // ok tested.
                var s = angular.copy($scope.server);
                var server = {};
                server['name'] = s.name;
                server['branch'] = s.branch;
                server['auto_deploy'] = s.auto_deploy;
                server['type'] = s.type;

                if (s.type == 1 || s.type == 2) {
                    server['host'] = s.host;
                    server['port'] = s.port;
                    server['username'] = s.username;
                    server['password'] = s.password;
                    server['path'] = s.path;
                    if (s.type == 1) {
                        server['secure'] = s.secure;
                    }
                }

                Api.createServer($scope.project_id, server).then(function () {
                    $scope.saving = false;
                }, function () {
                    $scope.saving = false;
                });
            }, function () {
                $scope.saving = false;
            });
        };

        $scope.testingConnection = false;
        $scope.testingErrorMessage = false;
        $scope.testingMessage = false;
        $scope.testConnection = function () {
            var defer = $q.defer();
            var server = {};
            var s = angular.copy($scope.server);
            server['type'] = s.type;
            if (s.type == 1 || s.type == 2) {
                server['host'] = s.host;
                server['port'] = s.port;
                server['username'] = s.username;
                server['password'] = s.password;
                server['path'] = s.path;
                if (s.type == 1) {
                    server['secure'] = s.secure;
                }
            }

            $scope.testingMessage = '';
            $scope.testingErrorMessage = '';

            $scope.testingConnection = true;
            Api.testServerConnectionByData(server).then(function (data) {
                $scope.testingConnection = false;
                $scope.testingMessage = 'Successfully connected. ';
                if (!data.empty) {
                    $scope.testingMessage += ' NOTE: The deploy path is not empty.'
                }
                $scope.isEmpty = data;
                defer.resolve();
            }, function (reason) {
                $scope.testingErrorMessage = reason;
                // Utils.error(reason, 'red', $scope.testConnection);
                $scope.testingConnection = false;
                defer.reject();
            });

            return defer.promise;
        };

        $scope.loadingBranches = false;
        $scope.branches = [];
        $scope.loadBranches = function () {
            $scope.loadingBranches = true;
            $scope.branches = [];
            Api.getAvailableBranchesByProject($scope.project_id).then(function (branches) {
                $scope.branches = branches;
                $scope.loadingBranches = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.loadBranches);
                $scope.loadingBranches = false;
            });
        };
        $scope.loadBranches();
    }
]);