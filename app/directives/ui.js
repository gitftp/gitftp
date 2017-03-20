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
    '$routeParams',
    '$location',
    '$timeout',
    'Api',
    function ($rootScope, Auth, Utils, $window, $routeParams, $location, $timeout, Api) {
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
                };

                scope.$location = $location;

                scope.showSyncButton = false;
                scope.project = false;
                scope.server_name = false;

                scope.$watch('$location.path()', function () {
                    $timeout(function () {
                        console.log('location changed ');
                        scope.showSyncButton = !!$routeParams.id;

                        if ($routeParams.id && $rootScope.projects[$routeParams.id]) {
                            scope.project = $rootScope.projects[$routeParams.id];
                        } else {
                            scope.project = false;
                        }

                        if (scope.project && $routeParams.server_id) {
                            angular.forEach(scope.project.servers, function (a) {
                                if (a.id == $routeParams.server_id) {
                                    scope.server_name = a.name;
                                }
                            });
                        } else {
                            scope.server_name = false;
                        }
                    }, 200);
                });

                scope.syncProject = function () {
                    if (!$routeParams.id)
                        return false;

                    Utils.notification('Pulling changes from repository');
                    Api.syncProject($routeParams.id).then(function () {
                        Utils.notification('Successfully pulled changes from repository', 'green');
                    }, function (reason) {
                        Utils.notification('Failed to pull changes: ' + reason, 'red');
                    });
                };
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
    'Const',
    'Api',
    function ($rootScope, Auth, Utils, $window, $routeParams, $ngConfirm, Const, Api) {
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
            }
        }
    }
]).directive('recordItem', [
    '$rootScope',
    'Utils',
    '$ngConfirm',
    'Const',
    'Api',
    '$timeout',
    function ($rootScope, Utils, $ngConfirm, Const, Api, $timeout) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/partials/recordItem.html',
            scope: {
                record: '=record'
            },
            link: function (scope, element) {
                scope.recordType = Utils.recordType;

                if (scope.record.commit)
                    scope.record.commit = JSON.parse(scope.record.commit);
                else
                    scope.record.commit = false;

                scope.errorMessage = function (text) {
                    $ngConfirm({
                        title: 'Failure reason',
                        content: "<pre>" + text + "</pre>",
                        type: 'red',
                    });
                };

                scope.logMessages = function (logFile) {
                    $ngConfirm({
                        title: 'Logs',
                        theme: 'light',
                        columnClass: 'l',
                        content: "" +
                        "<a ng-click='load()' class='pull-right'>" +
                        "<i class='zmdi zmdi-refresh'></i> Refresh</a>" +
                        "<p>Showing logs from logfile: " +
                        "<code>{{logFile}}</code>" +
                        "</p>" +
                        "<pre style='background: #f9f2f4;" +
                        "color: #d55c7a;border: none;'>{{msg ? msg: ''}}{{contents}}</pre>" +
                        "<a class='pull-right' ng-click='load()'><i class='zmdi zmdi-refresh'></i> Refresh</a>" +
                        "<div class='clearfix'></div>" +
                        "",
                        alignMiddle: false,
                        animation: 'top',
                        closeAnimation: 'top',
                        onScopeReady: function (scope) {
                            scope.logFile = logFile;
                            scope.contents = '';
                            scope.load = function () {
                                scope.msg = 'Loading...';
                                Api.getRecordLog(logFile).then(function (contents) {
                                    scope.msg = '';
                                    scope.contents = contents;
                                }, function (reason) {
                                    scope.msg = 'ERROR: ' + reason;
                                });
                            }
                            scope.load();
                        }
                    });
                };

                scope.progressStyle = {
                    'width': '0%',
                };

                var run = true;
                scope.getUpdate = function () {
                    if (!run)
                        return false;

                    var timer = false;
                    var status = parseInt(scope.record.status);
                    switch (status) {
                        case Const.record_status_new:
                            timer = 10000;
                            break;
                        case Const.record_status_in_progress:
                            timer = 5000;
                            break;
                        default:
                            timer = 0;
                    }
                    if (!timer) {
                        return false;
                    }
                    Api.getRecordStatus(scope.record.id).then(function (data) {
                        scope.record.total_files = data.total_files;
                        scope.record.processed_files = data.processed_files;
                        scope.record.edited_files = data.edited_files;
                        scope.record.added_files = data.added_files;
                        scope.record.deleted_files = data.deleted_files;
                        scope.record.status = data.status;
                        scope.record.log_file = data.log_file;
                        var s = ((scope.record.processed_files * 100) / scope.record.total_files);
                        if (s == 0)
                            s = 30;
                        scope.progressStyle = {
                            'width': s + '%',
                        };
                        $timeout(function () {
                            scope.getUpdate();
                        }, timer);
                    }, function (reason) {
                        console.warn(reason);
                    });
                };

                scope.$on('destroy', function () {
                    run = false;
                });
                scope.getUpdate();
            }
        }
    }
])