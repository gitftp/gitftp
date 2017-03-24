"use strict";

angular.module('AppProjectServerAdd', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/server/add', {
            templateUrl: 'app/pages/project/server/add.html',
            controller: 'createServerController',
        }).when('/view/:id/:name/server/:server_id', {
            templateUrl: 'app/pages/project/server/add.html',
            controller: 'createServerController',
        });
    }
]).controller('createServerController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    '$window',
    '$q',
    '$ngConfirm',
    'Components',
    '$location',
    'ProjectApi',
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $q, $ngConfirm, Components, $location, ProjectApi) {
        $scope.project_id = $routeParams.id;
        $scope.server_id = $routeParams.server_id;
        $scope.project = $scope.projects[$scope.project_id];
        $scope.api_path = API_PATH;
        if ($scope.server_id) {
            $scope.page = 'view-server';
            Utils.setTitle('View server');
        }
        else {
            $scope.page = 'new-server';
            Utils.setTitle('Add new server');
        }

        $scope.server = {
            type: "1",
            port: 21,
            secure: true,
        };

        $scope.typeChange = function () {
            if (angular.isDefined($scope.form) && angular.isDefined($scope.form.port)) {
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
            Utils.notification('Testing connection before saving', 'blue');
            $scope.testConnection().then(function () {
                // ok tested.
                var server = $scope.parseServerData();
                Utils.notification('Saving server, please wait..', 'blue');
                Api.createServer($scope.project_id, server).then(function (server_id) {
                    Utils.notification('Server saved successfully', 'green');
                    if (!$scope.server_id) {
                        ProjectApi.refreshProjects().then(function () {
                            $location.path('view/' + $scope.project_id + '/' + $scope.project.name + '/server/' + server_id + '/deploy');
                            $scope.saving = false;
                        }, function () {
                            $scope.saving = false;
                        });
                    } else {
                        $scope.saving = false;
                    }
                }, function (reason) {
                    $scope.saving = false;
                    Utils.error(reason, 'red', $scope.newServer);
                });
            }, function () {
                $scope.saving = false;
            });
        };

        $scope.keyCacheId = false;
        $scope.keyPubKey = false;
        $scope.generatingKey = false;
        $scope.useKey = function () {
            if ($scope.server.usePubKey && !$scope.keyPubKey) {
                // load once.
                $scope.generatingKey = true;
                Api.serverGenerateKey($scope.keyCacheId).then(function (data) {
                    $scope.keyCacheId = data.id;
                    $scope.keyPubKey = data.pu;
                    $scope.generatingKey = false;
                }, function (reason) {
                    Utils.notification(reason, 'red');
                    $scope.generatingKey = false;
                });
            } else {

            }
        };

        $scope.downloadPub = function () {
            Api.serverDownloadKey($scope.keyCacheId);
        };

        $scope.deletingServer = false;
        $scope.deleteServer = function () {
            $ngConfirm({
                title: 'Delete server',
                content: '' +
                'deleting the server will delete its records, no files will be changed on server<br>' +
                '<div class="md-form-group">' +
                '<label>Type the server name</label>' +
                '<input type="text" class="md-input" ng-change="oChange()" ng-model="server_name">' +
                '</div>',
                buttons: {
                    delete: {
                        btnClass: 'btn-red',
                        disabled: true,
                        action: function (scope, button) {
                            var self = this;
                            button.setDisabled(true);
                            button.setText('Deleting please wait..');

                            $scope.deletingServer = true;
                            Api.deleteServer($scope.server_id, $scope.project_id).then(function (data) {
                                $rootScope.$broadcast('refreshProjects');
                                $scope.deletingServer = false;
                                Utils.notification('Successfully deleted server', 'green');
                                self.close();
                                $location.path('view/' + $scope.project_id + '/' + $scope.project.name);
                            }, function (reason) {
                                $scope.deletingServer = false;
                                button.setDisabled(false);
                                button.setText('delete');
                                Utils.error(reason, 'red');
                            });
                            return false;
                        }
                    },
                    close: function () {

                    }
                },
                onScopeReady: function (scope) {
                    var self = this;
                    scope.server_name = '';
                    scope.oChange = function () {
                        self.buttons.delete.setDisabled((scope.server_name.toLowerCase() != $scope.server_name.toLowerCase()));
                    }
                }
            });
        };

        $scope.testingConnection = false;
        $scope.testingErrorMessage = false;
        $scope.testingMessage = false;

        $scope.parseServerData = function () {
            var server = {};
            var s = angular.copy($scope.server);
            server['type'] = s.type;
            server['name'] = s.name;
            server['branch'] = s.branch;
            server['auto_deploy'] = s.auto_deploy;
            server['id'] = s.id;
            server['path'] = s.path;
            if (s.type == 1 || s.type == 2) {
                server['host'] = s.host;
                server['port'] = s.port;
                server['username'] = s.username;
                server['password'] = s.password;
                server['edit_password'] = s.edit_password;
                if (s.type == 1) {
                    server['secure'] = s.secure;
                }
            }
            if (s.type == 2 && s.usePubKey && $scope.keyCacheId) {
                server['keyCacheId'] = $scope.keyCacheId;
            }
            return server;
        };

        $scope.testConnection = function () {
            var defer = $q.defer();
            var server = $scope.parseServerData();

            $scope.testingMessage = '';
            $scope.testingErrorMessage = '';

            $scope.testingConnection = true;
            Api.testServerConnectionByData(server, true).then(function (data) {
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

        $scope.explorePath = function () {
            $ngConfirm({
                title: 'Type the path',
                content: '' +
                '<input type="text" ng-model="path" ng-change="fetchPath()" class="md-input"/>' +
                '<div class="m-t-10" ng-if="error">Error: {{error}}</div>' +
                '<div class="m-t-10" ng-if="loading">Loading...</div>' +
                '<button type="button" ng-if="!error && !loading" class="btn btn-stroke btn-primary m-t-5 m-b-5 pull-right" ng-click="setPath()">Set as deploy path</button>' +
                '<div class="clearfix"></div>' +
                '<div class="list-group md-whiteframe-z0" style="max-height: 400px; overflow-y: auto">' +
                '<a ng-click="clicked(d)" class="list-group-item p-5" ng-repeat="d in dir">' +
                '{{apath}}{{d.path}} <span class="pull-right">{{d.type}}</span>' +
                '</a>' +
                '<span ng-if="!loading && dir.length == 0 && !error">This directory is empty</span>' +
                '</div>' +
                '',
                columnClass: 'm',
                alignMiddle: false,
                onOpen: function (scope) {
                    var that = this;
                    scope.path = $scope.server.path;
                    scope.loading = false;
                    scope.error = false;
                    scope.dir = [];
                    scope.apath = '';
                    scope.clicked = function (path) {
                        if (path.type != 'dir')
                            return;

                        scope.path = (scope.apath || '/') + path.path + '/';
                        scope.fetchPath();
                    };
                    scope.setPath = function () {
                        $scope.server['path'] = scope.path;
                        that.close();
                    };
                    scope.fetchPath = function () {
                        if (scope.path && scope.path.charAt(scope.path.length - 1) != '/')
                            return false;

                        scope.loading = true;
                        scope.error = false;
                        scope.dir = [];
                        scope.apath = scope.path;
                        var server = $scope.parseServerData();
                        server['path'] = scope.path;
                        Api.testServerConnectionByData(server, false).then(function (data) {
                            scope.dir = data.directories;
                            scope.loading = false;
                        }, function (reason) {
                            scope.error = reason;
                            scope.loading = false;
                        });
                    };
                    scope.fetchPath();
                }
            });
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

        $scope.loading = false;
        $scope.server_name = false;
        $scope.server.edit_password = true;

        $scope.load = function () {
            $scope.loading = true;
            Api.getServer($scope.server_id).then(function (data) {
                if (!data) {
                    $location.path('view/' + $scope.project_id + '/' + $scope.project.name);
                    return false;
                }
                $scope.server = data;
                $scope.server_name = $scope.server.name;
                $scope.server.auto_deploy = data.auto_deploy == '1';
                $scope.server.secure = data.secure == '1';
                $scope.loading = false;
                $scope.server.edit_password = false;
            }, function (reason) {
                $scope.loading = false;
                Utils.error(reason, 'red', $scope.load);
            });
        };
        if ($scope.server_id) {
            $scope.load();
        }

        $scope.showRevisions = function () {
            Components.showLatestRevisions({
                'title': 'Recent commits',
            }, $scope.project_id, $scope.server.branch).then(function (commit) {
                $scope.server.revision = commit.sha;
            }, function (reason) {
                Utils.notification(reason, 'red');
            });
        }
    }
]);