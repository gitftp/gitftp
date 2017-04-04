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

                scope.breadcumb = [];

                scope.$on('setBreadcrumb', function (event, params) {
                    scope.breadcumb = params;
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
                page: '=page',
                current: '=current',
            },
            link: function (scope, element) {
                scope.id = $routeParams.id;
                scope.project = $rootScope.projects[scope.id];
                scope.server = {};
                scope.server_id = $routeParams.server_id || false;

                scope.$on('projectsUpdated', function () {
                    console.log('Directive project update.');
                    scope.project = $rootScope.projects[scope.id];
                    scope.getServer();
                });

                scope.getServer = function () {
                    if (scope.server_id) {
                        angular.forEach(scope.project.servers, function (a) {
                            if (a.id == scope.server_id)
                                scope.server = a;
                        });
                    }
                };
                scope.getServer();

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
    '$q',
    function ($rootScope, Utils, $ngConfirm, Const, Api, $timeout, $q) {
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

                scope.logMessages = function (logFile, errorMessage) {
                    scope.jc = $ngConfirm({
                        title: 'Deploy output',
                        theme: 'light',
                        columnClass: 'col-md-12',
                        content: "" +
                        "<a ng-click='load()' class='pull-right'>" +
                        "<i class='zmdi zmdi-refresh'></i> {{loading? 'Loading..' : 'Refresh'}}</a>" +
                        "<p>Showing logs from logfile: " +
                        "<code>{{logFile}}</code>" +
                        "</p>" +
                        "<div ng-if='error'>" +
                        "<p>Error:</p>" +
                        "<pre class='red'>{{error}}</pre>" +
                        "</div>" +
                        "<pre class='lscroll' style='background: #004556;overflow: auto; max-height: 500px;" +
                        "color: white;border: none;'>{{contents}}</pre>" +
                        "<a class='pull-right' ng-click='load()'><i class='zmdi zmdi-refresh'></i> {{loading? 'Loading..' : 'Refresh'}}</a>" +
                        "<div class='clearfix'></div>" +
                        "",
                        alignMiddle: false,
                        buttons: {
                            close: function () {

                            }
                        },
                        closeIcon: true,
                        animation: 'opacity',
                        closeAnimation: 'opacity',
                        onScopeReady: function (scope2) {
                            var that = this;
                            scope2.logFile = logFile;
                            scope2.contents = '';
                            scope2.error = errorMessage;
                            scope2.loading = false;
                            scope2.load = function () {
                                var defer = $q.defer();
                                scope2.msg = 'Loading...';
                                scope2.loading = true;
                                Api.getRecordLog(logFile).then(function (contents) {
                                    scope2.msg = '';
                                    scope2.contents = contents;
                                    scope2.loading = false;
                                    // angular.element(lscroll)
                                    $timeout(function () {
                                        $('.lscroll').scrollTop($('.lscroll').get(0).scrollHeight)
                                    }, 500);
                                    defer.resolve();
                                }, function (reason) {
                                    scope2.loading = false;
                                    scope2.msg = 'ERROR: ' + reason;
                                    defer.reject();
                                });

                                return defer.promise;
                            };

                            scope2.load();

                            var loadAgain = function () {
                                if ((scope.record.status == Const.record_status_new || scope.record.status == Const.record_status_in_progress) && that.isOpen()) {
                                    $timeout(function () {
                                        scope2.load().then(function () {
                                            loadAgain();
                                        });
                                    }, 3000);
                                }
                            };
                            loadAgain();
                        },
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

                scope.startingCloning = false;
                scope.startCloning = function () {
                    scope.startingCloning = true;
                    Api.startProjectCloning(scope.record.project_id).then(function () {
                        scope.startingCloning = false;
                        window.location.reload();
                    }, function (reason) {
                        Utils.notification(reason, 'red');
                        scope.startingCloning = false;
                    });
                };

            }
        }
    }
])