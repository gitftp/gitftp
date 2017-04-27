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
"use strict";

angular.module('AppFilters', [])
    .filter('sha', function () {
        return function (n) {
            return n.toString().substring(0, 16);
        }
    })
    .filter('fileName', function () {
        return function (filePath) {
            filePath = filePath.toString();
            return filePath.substring(filePath.lastIndexOf('/') + 1);
        }
    })
    .filter('bytes', function () {
        return function (bytes, precision) {
            bytes += 1000;
            if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) return '-';
            if (typeof precision === 'undefined') precision = 1;
            var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
                number = Math.floor(Math.log(bytes) / Math.log(1024));
            return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number];
        }
    });
"use strict";

angular.module('ServiceUtils', [
    'ngSanitize',
]).service('Utils', [
    '$rootScope',
    '$localStorage',
    '$ngConfirm',
    '$http',
    '$log',
    'Const',
    function ($rootScope, $localStorage, $ngConfirm, $http, $log, Const) {
        var that = this;

        this.defaultTitle = 'Gitftp';

        this.en = function (s) {
            return encodeURIComponent(btoa(btoa(s << 100)))
        };
        this.de = function (s) {
            return atob(atob(decodeURIComponent(s))) >> 100;
        };

        this.previouslyShownError = false;
        this.error = function (text, type, retryCallback) {
            if (this.previouslyShownError && this.previouslyShownError.isOpen())
                return false;

            text = text || false;

            var buttons = {
                ok: function () {

                },
            };

            if (retryCallback)
                buttons['retry'] = retryCallback;

            this.previouslyShownError = $ngConfirm({
                title: 'Heads up',
                content: "Something went wrong" +
                "<div ng-show='errorMessage'>" +
                "<hr>" +
                "Error: <br>" +
                "<code>{{errorMessage}}</code></div>",
                buttons: buttons,
                type: type || 'red',
                onScopeReady: function (scope) {
                    scope.errorMessage = text;
                }
            });

            return this.previouslyShownError;
        };

        this.notification = function (text, type) {
            var t = 'alert';
            switch (type) {
                case 'red':
                    t = 'error';
                    break;
                case 'green':
                    t = 'success';
                    break;
                case 'orange':
                    t = 'warning';
                    break;
                case 'blue':
                    t = 'information';
                    break;
            }


            window.noty({
                text: text,
                type: t,
                theme: 'relax',
                layout: 'bottomLeft',
                timeout: 5000,
                progressBar: false,
                animation: {
                    open: {height: 'toggle'},
                    close: {height: 'toggle'},
                    easing: 'swing',
                    speed: 350
                },
            });
        };

        this.setTitle = function (title, full) {
            full = full || false;
            that.title = title;
            if (!full)
                document.title = that.title + ' | ' + that.defaultTitle;
            else
                document.title = that.title;
            return document.title;
        };
        this.isEmpty = function (a) {
            return jQuery.isEmptyObject(a);
        };

        this.chunk_array = function (array, chunkSize) {
            return [].concat.apply([],
                array.map(function (elem, i) {
                    return i % chunkSize ? [] : [array.slice(i, i + chunkSize)];
                })
            );
        };

        this.hash = function (string) {
            string = string.toString();
            var hash = 0;
            if (string.length == 0) return hash;
            for (var i = 0; i < string.length; i++) {
                var char = string.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash; // Convert to 32bit integer
            }
            return hash;
        };

        this.cloneState = function (state) {
            state = parseInt(state);
            if (state == Const.clone_state_cloned)
                return 'Cloned';
            else if (state == Const.clone_state_cloning)
                return 'Cloning';
            else if (state == Const.clone_state_not_cloned)
                return 'Not cloned';
            else
                return state;
        };

        this.recordStatus = function (state) {
            state = parseInt(state);
            switch (state) {
                case Const.record_status_failed:
                    return 'Failed';
                case Const.record_status_in_progress:
                    return 'In progress';
                case Const.record_status_new:
                    return 'New';
                case Const.record_status_success:
                    return 'Success';
                default:
                    return state;
            }
        };

        this.recordType = function (state) {
            state = parseInt(state);
            switch (state) {
                case Const.record_type_clone:
                    return 'Clone';
                case Const.record_type_update:
                    return 'Update';
                case Const.record_type_fresh_upload:
                    return 'Fresh upload';
                default:
                    return state;
            }
        };

        this.serverType = function (state) {
            state = parseInt(state);
            switch (state) {
                case Const.server_type_ftp:
                    return 'FTP';
                case Const.server_type_sftp:
                    return 'SFTP';
                case Const.server_type_local:
                    return 'LOCAL';
                default:
                    return state;
            }
        };
    }
]);
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
"use strict";

angular.module('ServiceApi', []).factory('Api', [
    '$http',
    '$q',
    'Utils',
    '$rootScope',
    '$ngConfirm',
    '$timeout',
    function ($http, $q, Utils, $rootScope, $ngConfirm, $timeout) {
        return {
            /**
             * Create or save user
             */
            saveUser: function (user) {
                var defer = $q.defer();
                $http.post(API_PATH + 'users/save_user', {
                    user: user,
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
             * Get list of users
             */
            getUsers: function (offset) {
                var defer = $q.defer();
                $http.post(API_PATH + 'users/list', {
                    offset: offset,
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
             * Test connection to server
             */
            testServerConnectionByData: function (server_data, writeTest) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/test', {
                    server: server_data,
                    writeTest: writeTest,
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
             * Get commits from project
             */
            getRevisions: function (project_id, branch) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/revisions', {
                    project_id: project_id,
                    branch: branch,
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
             * start cloning a project
             */
            startProjectCloning: function (project_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/clone', {
                    project_id: project_id,
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
             * Get server but without password.
             * @param server_id
             */
            getServer: function (server_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/view', {
                    server_id: server_id,
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
             * Get server but without password.
             * @param project_id
             */
            getServers: function (project_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/view', {
                    project_id: project_id,
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
             * get records for project.
             * server_id is optional
             * project_id is required
             */
            getRecordStatus: function (record_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/record_status', {
                    record_id: record_id,
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
             * Checks if the hook exists
             */
            checkHook: function (project_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/check_hook', {
                    project_id: project_id,
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
             * Checks if the hook exists
             */
            createHook: function (project_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/create_hook', {
                    project_id: project_id,
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
             * Delete the project
             */
            deleteProject: function (project_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/delete', {
                    project_id: project_id,
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
             * Delete the project
             */
            deleteServer: function (server_id, project_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/delete', {
                    project_id: project_id,
                    server_id: server_id,
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
             * Get log file
             * @param filename
             */
            updateProject: function (project_id, set) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/update', {
                    project_id: project_id,
                    project: set,
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
             * Get log file
             * @param filename
             */
            getRecordLog: function (filename) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/log_file', {
                    filename: filename,
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
             * start cloning a project
             */
            getLatestRecords: function (project_id, latest_id, server_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/records', {
                    project_id: project_id,
                    latest_id: latest_id,
                    server_id: server_id,
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
             * get records for project.
             * server_id is optional
             * project_id is required
             */
            getRecords: function (project_id, server_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/records', {
                    project_id: project_id,
                    server_id: server_id,
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
             * Get all projects
             */
            getProjects: function () {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/view', {}).then(function (res) {
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
             * Get project by id
             */
            getSingleProject: function (id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/view', {
                    project_id: id
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
             * create a server for a project
             */
            createServer: function (project_id, set) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/create', {
                    server: set,
                    project_id: project_id,
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
             * getServerKey
             */
            getServerKey: function (cacheId) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/key', {
                    id: cacheId
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
             * serverDownloadKey
             */
            serverDownloadKey: function (cacheId) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/download_key', {
                    id: cacheId
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
             * create a project
             */
            createProject: function (set) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/create', {
                    project: set
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
             * compare commits
             */
            compareCommits: function (project_id, server_id, source, target) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/compare', {
                    project_id: project_id,
                    server_id: server_id,
                    source_revision: source,
                    target_revision: target,
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
             * Pull changes from remote
             */
            syncProject: function (project_id) {
                var defer = $q.defer();

                $http.post(API_PATH + 'projects/pull_changes', {
                    project_id: project_id,
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
             * add a new record and start deploy
             */
            applyDeploy: function (project_id, server_id, deploy) {
                var defer = $q.defer();
                $http.post(API_PATH + 'server/deploy', {
                    project_id: project_id,
                    server_id: server_id,
                    deploy: deploy,
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
             * get available branches for the repository by project id
             */
            getAvailableBranchesByProject: function (project_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'projects/list_available_branches', {
                    project_id: project_id
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
             * get available branches for the repository
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
             * get oauth connected accounts
             */
            disconnectConnectedAccounts: function (provider_id) {
                var defer = $q.defer();
                $http.post(API_PATH + 'accounts/disconnect', {
                    id: provider_id,
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
             * get oauth applications
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
             * get oauth applications
             */
            updatePassword: function (oldPass, newPass) {
                var defer = $q.defer();
                $http.post(API_PATH + 'auth/update_password', {
                    'old_password': oldPass,
                    'new_password': newPass
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
]).factory('ProjectApi', [
    '$rootScope',
    'Api',
    '$interval',
    '$timeout',
    'Utils',
    '$q',
    function ($rootScope, Api, $interval, $timeout, Utils, $q) {
        return {
            isListenerActive: false,
            registerListeners: function () {
                if (this.isListenerActive)
                    return false;

                var that = this;
                $rootScope.$on('refreshProjects', function () {
                    that.refreshProjects();
                });

                var refreshProjectsLoop = function () {
                    $timeout(function () {
                        that.refreshProjects().then(function () {
                            refreshProjectsLoop();
                        });
                    }, 5000);
                };

                refreshProjectsLoop();

                this.isListenerActive = true;
            },
            refreshProjects: function () {
                var defer = $q.defer();
                Api.getProjects().then(function (data) {
                    var object = {};
                    angular.forEach(data, function (a) {
                        object[a.id] = a;
                    });
                    data = undefined;
                    if (!angular.equals($rootScope.projects, object)) {
                        $rootScope.projects = object;
                        $rootScope.$broadcast('projectsUpdated');
                    }
                    object = undefined;
                    defer.resolve();
                }, function (reason) {
                    console.error(reason);
                    defer.resolve();
                });

                return defer.promise;
            },
        };
    }
]);
"use strict";

angular.module('ServiceComponents', [
    'ngSanitize',
]).service('Components', [
    '$rootScope',
    '$localStorage',
    '$ngConfirm',
    '$http',
    '$log',
    'Const',
    'Api',
    '$q',
    function ($rootScope, $localStorage, $ngConfirm, $http, $log, Const, Api, $q) {

        this.showLatestRevisions = function (options, project_id, branch) {
            var title = options['title'] || 'Recent commits';

            var defer = $q.defer();

            $ngConfirm({
                title: title,
                content: '' +
                '<div class="md-form-group p-b-10">' +
                '<input type="text" class="md-input" ng-model="custom_revision">' +
                '<label>Revision SHA</label>' +
                '</div>' +
                '<button type="button" ng-click="okCustom(custom_revision)" class="pull-right btn btn-stroke btn-primary btn-rounded m-b-10">Set revision</button>' +
                '<div class="clearfix"></div>' +
                '<div class="loader p-25 p-t-70" ng-if="loading" style="width: 60px"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/></svg></div>' +
                '<p class="text-center" ng-if="loading">Loading recent commits</p>' +
                '<div ng-if="error && !loading" class="alert alert-danger">{{error}}</div>' +
                '<div ng-if="!loading && !error">' +
                '<p class="text-muted">or select from latest</p>' +
                '<p ng-if="!revisions.length">Revisions not found</p>' +
                '<div class="">' +
                '<a class="p-t-10 p-b-10 block b-t " ng-click="select(r)" ng-repeat="r in revisions">' +
                '<strong>{{r.message}}</strong> <code class="pull-right"><small class="">{{r.sha | sha}}</small></code>' +
                '<br><small class="text-muted">{{r.author}} committed on {{r.time | amFromUnix | amDateFormat : "MMM DD, YYYY"}}</small>' +
                '</a>' +
                '</div>' +
                '</div>',
                animation: 'top',
                closeAnimation: 'top',
                columnClass: 'm',
                onScopeReady: function (scope) {
                    var that = this;
                    that.commit = false;
                    scope.loading = true;
                    scope.revisions = [];

                    Api.getRevisions(project_id, branch).then(function (revisions) {
                        scope.revisions = revisions;
                        scope.loading = false;
                    }, function (reason) {
                        scope.loading = false;
                        scope.error = reason;
                    });

                    scope.select = function (commit) {
                        that.commit = commit;
                        that.close();
                    };
                    scope.okCustom = function (sha) {
                        that.commit = {
                            sha: sha,
                        };
                        that.close();
                    }
                },
                onClose: function () {
                    defer.resolve(this.commit);
                }
            });

            return defer.promise;
        }
    }
]);
"use strict";

angular.module('AppHome', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: 'app/pages/home/home.html',
            controller: 'homeController',
        }).when('/home', {
            templateUrl: 'app/pages/home/home.html',
            controller: 'homeController',
        });
    }
]).controller('homeController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    function ($scope, $rootScope, $routeParams, Utils) {
        Utils.setTitle('Home');
        $rootScope.$broadcast('setBreadcrumb', []);

        $scope.projects_array = [];
        $scope.parseProjects = function () {
            $scope.projects_array = [];
            angular.forEach($rootScope.projects, function (a) {
                $scope.projects_array.push(a);
            });
        };
        $scope.parseProjects();
        $scope.$on('projectsUpdated', $scope.parseProjects);
    }
]);
"use strict";

angular.module('AppProjectNew', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/project/new', {
            templateUrl: 'app/pages/project/new.html',
            controller: 'createProjectController',
        });
    }
]).controller('createProjectController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    '$window',
    '$location',
    'ProjectApi',
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $location, ProjectApi) {
        Utils.setTitle('Create new project');
        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'New project'
            }
        ]);

        $scope.available_repos = [];
        $scope.loading = false;
        $scope.selectedRepo = false;
        $scope.availableBranches = [];
        $scope.loadingBranches = false;

        $scope.load = function () {
            $scope.loading = true;
            Api.getAvailableRepositories().then(function (data) {
                $scope.available_repos = data;
                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };
        $scope.load();

        $scope.getBranches = function () {
            $scope.loadingBranches = true;
            Api.getAvailableBranches(angular.copy($scope.selectedRepo)).then(function (branches) {
                $scope.loadingBranches = false;
                $scope.availableBranches = branches;
            }, function (reason) {
                $scope.loadingBranches = false;
                Utils.error(reason, 'red', $scope.getBranches);
            })
        };

        $scope.selectRepo = function (repo) {
            $scope.selectedRepo = repo;
            $scope.availableBranches = [];

            $scope.getBranches();
        };

        $scope.creating = false;
        $scope.createProject = function () {
            if (!$scope.selectedRepo || $scope.availableBranches.length == 0)
                return false;

            $scope.creating = true;
            Api.createProject({
                repo: $scope.selectedRepo,
                branches: $scope.availableBranches
            }).then(function (project_id) {
                ProjectApi.refreshProjects().then(function () {
                    var project = $rootScope.projects[project_id];
                    $location.path('view/' + project.id + '/' + project.name);
                    $scope.creating = false;
                }, function () {
                    $window.location.href = BASE + 'view/' + project_id + '/loading';
                    $scope.creating = false;
                });
            }, function (reason) {
                Utils.error(reason, 'red', $scope.createProject);
                $scope.creating = false;
            })
        };
    }
]);
"use strict";

angular.module('AppProjectView', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name', {
            templateUrl: 'app/pages/project/view.html',
            controller: 'viewProjectController',
        });
    }
]).controller('viewProjectController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    'Const',
    '$timeout',
    '$ngConfirm',
    function ($scope, $rootScope, $routeParams, Utils, Api, Const, $timeout, $ngConfirm) {
        $scope.id = $routeParams.id;
        $scope.project = $rootScope.projects[$scope.id];
        Utils.setTitle($scope.project.name);

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "view/" + $scope.project.id + "/" + $scope.project.name,
                name: $scope.project.name
            },
            {
                link: "",
                name: "Deploy activity"
            }
        ]);

        $scope.records = [];
        $scope.loadingRecords = false;
        $scope.totalRecords = 0;
        $scope.loading = false;

        $scope.page = 'view-project';

        $scope.$on('projectsUpdated', function () {
            console.log('projectsUpdated');
            $scope.project = $rootScope.projects[$scope.id];
        });

        $scope.loadRecords = function () {
            $scope.loadingRecords = true;
            Api.getRecords($scope.id).then(function (records) {
                $scope.records = records.list;
                $scope.totalRecords = records.total;
                $scope.loadingRecords = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.loadRecords);
                $scope.loadingRecords = false;
            })
        };

        $scope.startingCloning = false;
        $scope.startCloning = function () {
            $scope.startingCloning = true;
            Api.startProjectCloning($scope.id).then(function () {
                $scope.startingCloning = false;
                $scope.loadRecords();
            }, function (reason) {
                $scope.startingCloning = false;
                Utils.notification(reason, 'red');
            });
        };

        var loaded = true;

        $scope.checkForNewRecords = function () {
            if (!loaded)
                return false;

            console.log('checkForNewRecords');
            if (!$scope.records.length) {
                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
                return false;
            }

            Api.getLatestRecords($scope.id, $scope.records[0].id).then(function (data) {
                if (data.list.length) {
                    $scope.records = data.list.concat($scope.records);
                    // angular.forEach(data.list, function (rec) {
                    //     $scope.records.unshift(rec);
                    // });
                }


                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
            }, function (reason) {
                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
            });
        };

        $scope.checkForNewRecords();

        $scope.$on('$destroy', function () {
            loaded = false;
        });

        $scope.loadRecords();

    }
]);
"use strict";

angular.module('AppProjectServerAdd', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/server/add', {
            templateUrl: 'app/pages/project/server/addEdit.html',
            controller: 'createServerController',
        }).when('/view/:id/:name/server/:server_id/settings', {
            templateUrl: 'app/pages/project/server/addEdit.html',
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
            $scope.page = 'server-settings';
            Utils.setTitle('View server');
        }
        else {
            $scope.page = 'new-server';
            Utils.setTitle('Add new server');

            $rootScope.$broadcast('setBreadcrumb', [
                {
                    link: "view/" + $scope.project.id + "/" + $scope.project.name,
                    name: $scope.project.name
                },
                {
                    link: "",
                    name: 'Add server'
                }
            ]);
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

        $scope.keyPubKey = false;
        $scope.gettingKey = false;

        $scope.getKey = function () {
            if ($scope.server.useKey && !$scope.keyPubKey) {
                // load once.
                $scope.gettingKey = true;
                Api.getServerKey($scope.server.key_id).then(function (data) {
                    $scope.server.key_id = data.id;
                    $scope.keyPubKey = data.pu;
                    $scope.gettingKey = false;
                }, function (reason) {
                    Utils.notification(reason, 'red');
                    $scope.gettingKey = false;
                });
            } else {

            }
        };

        $scope.downloadPub = function () {
            Api.serverDownloadKey($scope.server.key_id);
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
            if (s.type == 2 && $scope.server.useKey && $scope.server.key_id) {
                server['key_id'] = $scope.server.key_id;
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

                if ($scope.server.key_id) {
                    $scope.server.useKey = true;
                    $scope.getKey();
                } else {
                    $scope.server.useKey = false;
                }

                $rootScope.$broadcast('setBreadcrumb', [
                    {
                        link: "view/" + $scope.project.id + "/" + $scope.project.name,
                        name: $scope.project.name
                    },
                    {
                        link: "view/" + $scope.project.id + "/" + $scope.project.name + "/server/" + $scope.server_id,
                        name: $scope.server_name
                    },
                    {
                        link: "",
                        name: "Setup"
                    }
                ]);
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
"use strict";

angular.module('AppProjectServerDeploy', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/server/:server_id/deploy', {
            templateUrl: 'app/pages/project/server/deploy.html',
            controller: 'serverDeployController',
        });
    }
]).controller('serverDeployController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    '$window',
    '$q',
    '$ngConfirm',
    'Const',
    'Components',
    '$location',
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $q, $ngConfirm, Const, Components, $location) {
        $scope.project_id = $routeParams.id;
        $scope.server_id = $routeParams.server_id;
        $scope.project = $rootScope.projects[$scope.project_id];

        $scope.deploy = {};
        $scope.page = 'server-deploy';
        Utils.setTitle('Deploy');

        var server = {};
        angular.forEach($scope.project.servers, function (s) {
            if (s.id == $scope.server_id)
                server = s;
        });
        $scope.server = server;
        if ($scope.server.revision) {
            $scope.deploy.type = Const.record_type_update.toString();
        } else {
            $scope.deploy.type = Const.record_type_fresh_upload.toString();
        }

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "view/" + $scope.project.id + "/" + $scope.project.name,
                name: $scope.project.name
            },
            {
                link: "view/" + $scope.project.id + "/" + $scope.project.name + "/server/" + $scope.server_id,
                name: $scope.server.name
            },
            {
                link: "",
                name: "Deploy"
            }
        ]);


        // deploy to revision

        $scope.fetchingComparision = false;
        $scope.targetCommit = $scope.server.branch;
        $scope.targetChanges = {};
        $scope.compareError = false;
        $scope.fetchComparision = function () {
            $scope.compareError = false;
            $scope.fetchingComparision = true;
            $scope.targetChanges = {};
            Api.compareCommits($scope.project_id, $scope.server_id, $scope.server.revision, $scope.targetCommit)
                .then(function (comparison) {
                    $scope.fetchingComparision = false;
                    $scope.targetChanges = comparison;
                }, function (reason) {
                    $scope.fetchingComparision = false;
                    $scope.compareError = reason;
                });
        };

        $scope.deploySpecific = function () {
            Components.showLatestRevisions({
                title: 'Deploy to revision'
            }, $scope.project_id, $scope.server.branch).then(function (commit) {
                if (!commit)
                    return;
                $scope.targetCommit = commit.sha;
                $scope.fetchComparision();
            }, function (reason) {
                Utils.error(reason, 'red');
            });
        };

        $scope.revisionDeployProcessing = false;
        $scope.revisionDeploy = function () {
            var deploy = {};
            deploy.type = Const.record_type_update;
            deploy.target_revision = $scope.targetCommit;
            $scope.revisionDeployProcessing = true;
            Api.applyDeploy($scope.project_id, $scope.server_id, deploy).then(function (res) {
                $scope.revisionDeployProcessing = false;
                $location.path('view/' + $scope.project_id + '/' + $scope.projects[$scope.project_id].name);
            }, function (reason) {
                Utils.error(reason, 'red', $scope.revisionDeploy);
                $scope.revisionDeployProcessing = false;
            });
        };

        // END deploy to revision

        // fresh upload

        $scope.freshDeployProcessing = false;
        $scope.freshDeploy = function () {
            var deploy = {};
            deploy.type = Const.record_type_fresh_upload;
            deploy.target_revision = $scope.selectedCommit.sha;
            $scope.freshDeployProcessing = true;
            Api.applyDeploy($scope.project_id, $scope.server_id, deploy).then(function (res) {
                $scope.freshDeployProcessing = false;
                $location.path('view/' + $scope.project_id + '/' + $scope.projects[$scope.project_id].name);
            }, function (reason) {
                Utils.error(reason, 'red', $scope.freshDeploy);
                $scope.freshDeployProcessing = false;
            })
        };

        $scope.gettingLatest = false;
        $scope.selectedCommit = {};
        $scope.getLatestRevision = function () {
            if (Object.keys($scope.selectedCommit).length)
                return false;

            $scope.gettingLatest = true;
            Api.getRevisions($scope.project_id, $scope.server.branch).then(function (revisions) {
                $scope.selectedCommit = revisions[0];
                $scope.gettingLatest = false;
            }, function (reason) {
                $scope.gettingLatest = false;
                Utils.notification(reason, 'red');
            });
        };

        $scope.selectRevision = function () {
            Components.showLatestRevisions({
                title: 'Upload revision'
            }, $scope.project_id, $scope.server.branch).then(function (commit) {
                if (!commit)
                    return;

                $scope.selectedCommit = commit;
            }, function (reason) {
                Utils.error(reason, 'red');
            });
        };

        // END fresh upload

        $scope.typeChange = function () {
            if ($scope.deploy.type == Const.record_type_update) {
                $scope.fetchComparision();
            } else {
                $scope.getLatestRevision();
            }
        };
        $scope.typeChange();

    }
]);
"use strict";

angular.module('AppProjectServerView', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/server/:server_id', {
            templateUrl: 'app/pages/project/server/view.html',
            controller: 'viewProjectServerController',
        });
    }
]).controller('viewProjectServerController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    'Const',
    '$timeout',
    '$ngConfirm',
    function ($scope, $rootScope, $routeParams, Utils, Api, Const, $timeout, $ngConfirm) {
        $scope.id = $routeParams.id;
        $scope.project = $rootScope.projects[$scope.id];
        $scope.server_id = $routeParams.server_id;
        var server = {};
        angular.forEach($scope.projects[$scope.id].servers, function (s) {
            if (s.id == $scope.server_id)
                server = s;
        });
        $scope.server = server;

        Utils.setTitle($scope.server.name);

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "view/" + $scope.project.id + "/" + $scope.project.name,
                name: $scope.project.name
            },
            {
                link: "",
                name: $scope.server.name
            },
            {
                link: "",
                name: "Deploy activity"
            }
        ]);

        $scope.records = [];
        $scope.loadingRecords = false;
        $scope.totalRecords = 0;
        $scope.loading = false;

        $scope.page = 'view-server';

        $scope.$on('projectsUpdated', function () {
            console.log('projectsUpdated');
            $scope.project = $rootScope.projects[$scope.id];
        });

        $scope.loadRecords = function () {
            $scope.loadingRecords = true;
            Api.getRecords($scope.id, $scope.server_id).then(function (records) {
                $scope.records = records.list;
                $scope.totalRecords = records.total;
                $scope.loadingRecords = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.loadRecords);
                $scope.loadingRecords = false;
            })
        };

        var loaded = true;
        $scope.checkForNewRecords = function () {
            if (!loaded)
                return false;

            console.log('checkForNewRecords');
            if (!$scope.records.length) {
                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
                return false;
            }

            Api.getLatestRecords($scope.id, $scope.records[0].id, $scope.server_id).then(function (data) {
                if (data.list.length) {
                    $scope.records = data.list.concat($scope.records);
                }

                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
            }, function (reason) {
                $timeout(function () {
                    $scope.checkForNewRecords();
                }, 4000);
            });
        };

        $scope.checkForNewRecords();

        $scope.$on('$destroy', function () {
            loaded = false;
        });

        $scope.loadRecords();

    }
]);
"use strict";

angular.module('AppProjectSettings', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/view/:id/:name/settings', {
            templateUrl: 'app/pages/project/settings/basic.html',
            controller: 'viewProjectSettingsBasicController',
        });
    }
]).controller('viewProjectSettingsBasicController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    'Const',
    '$timeout',
    '$ngConfirm',
    '$location',
    function ($scope, $rootScope, $routeParams, Utils, Api, Const, $timeout, $ngConfirm, $location) {
        $scope.id = $routeParams.id;
        $scope.project = angular.copy($rootScope.projects[$scope.id]);
        Utils.setTitle($scope.project.name);
        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "view/" + $scope.id + "/" + $scope.project.name,
                name: $scope.project.name,
            },
            {
                link: "",
                name: 'Settings'
            }
        ]);

        $scope.page = 'project-settings';
        $scope.current = 'project-settings-basic';

        $scope.hookExists = false;
        $scope.hookLoading = false;
        $scope.checkHook = function () {
            $scope.hookLoading = true;
            Api.checkHook($scope.id).then(function (data) {
                $scope.hookLoading = false;
                $scope.hookExists = !!data;
            }, function (reason) {
                $scope.hookLoading = false;
                Utils.notification(reason, 'red');
            })
        };
        $scope.checkHook();

        $scope.creatingHook = false;
        $scope.createHook = function () {
            $scope.creatingHook = true;
            Api.createHook($scope.id).then(function (data) {
                $scope.creatingHook = false;
                $scope.checkHook();
            }, function (reason) {
                $scope.creatingHook = false;
                Utils.notification(reason, 'red');
            });
        };

        $scope.savingSettings = false;
        $scope.saveSettings = function () {
            $scope.savingSettings = true;
            Api.updateProject($scope.id, {
                name: $scope.project.name
            }).then(function (data) {
                $scope.savingSettings = false;
                Utils.notification('Successfully applied changes', 'green');
            }, function (reason) {
                $scope.savingSettings = false;
                Utils.notification(reason, 'red');
            })
        };

        $scope.deleteProject = function () {
            $ngConfirm({
                title: 'Delete project',
                content: '' +
                'deleting the project will delete the records, and servers created under it. <br>' +
                '<div class="md-form-group">' +
                '<label>Type the project name</label>' +
                '<input type="text" class="md-input" ng-change="oChange()" ng-model="project_name">' +
                '</div>',
                buttons: {
                    delete: {
                        btnClass: 'btn-red',
                        disabled: true,
                        action: function (scope, button) {
                            var self = this;
                            button.setDisabled(true);
                            button.setText('Deleting please wait..');

                            Api.deleteProject($scope.id).then(function (res) {
                                button.setDisabled(false);
                                button.setText('Delete');
                                $location.path('/');
                                $rootScope.$broadcast('refreshProjects');
                                self.close();
                            }, function (reason) {
                                Utils.notification(reason, 'red');
                                button.setDisabled(false);
                                button.setText('Delete');
                            });
                            return false;
                        }
                    },
                    close: function () {

                    }
                },
                onScopeReady: function (scope) {
                    var self = this;
                    scope.project_name = '';
                    scope.oChange = function () {
                        self.buttons.delete.setDisabled((scope.project_name.toLowerCase() != $scope.project.name.toLowerCase()));
                    }
                }
            })
        };
    }
]);
"use strict";

angular.module('AppSettings', [
    'ngRoute',
]).config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/settings', {
            templateUrl: 'app/pages/settings/pages/settings.html',
            controller: 'accountSettingsController',
        }).when('/settings/users', {
            templateUrl: 'app/pages/settings/pages/users.html',
            controller: 'usersController',
        }).when('/settings/users/add', {
            templateUrl: 'app/pages/settings/pages/userAdd.html',
            controller: 'userAddController',
        }).when('/settings/oauth-applications', {
            templateUrl: 'app/pages/settings/pages/oauth-applications.html',
            controller: 'oAuthController',
        }).when('/settings/connected-accounts', {
            templateUrl: 'app/pages/settings/pages/connected-accounts.html',
            controller: 'connectedAccountsController',
            reloadOnSearch: false,
        });
    }
]).directive('settingsSidebar', [
    '$rootScope',
    '$location',
    function ($rootScope, $location) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/pages/settings/sidebar.html',
            scope: {
                page: '=',
            },
            link: function (scope, element) {
                scope.currentPage = $location.path();
                scope.isCurrent = function (path) {
                    return path == scope.currentPage;
                }
            }
        }
    }
]).controller('accountSettingsController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    '$timeout',
    function ($scope, $rootScope, $routeParams, Utils, Api, $timeout) {
        Utils.setTitle('Account settings');

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'Account'
            }
        ]);

        $scope.passChange = {};
        $scope.passError = false;
        $scope.passLoading = false;
        $scope.passSuccess = false;
        $scope.changePassword = function () {
            $scope.passError = false;
            $scope.passLoading = true;
            $scope.passSuccess = false;
            Api.updatePassword($scope.passChange.oldPass, $scope.passChange.newPass).then(function (data) {
                $scope.passLoading = false;
                $scope.passSuccess = true;
                $scope.passChange.oldPass = '';
                $scope.passChange.newPass = '';
                $timeout(function () {
                    $scope.passSuccess = false;
                }, 3000);
            }, function (reason) {
                $scope.passLoading = false;
                $scope.passError = reason;
                $scope.passSuccess = false;
            })
        };
    }
]).controller('usersController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    'UserConst',
    function ($scope, $rootScope, $routeParams, Utils, Api, UserConst) {
        Utils.setTitle('Users');
        $scope.userGroup = UserConst;
        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'Users'
            }
        ]);

        $scope.totalItems = 0;
        $scope.currentPage = 1;
        $scope.itemsPerPage = 10;
        $scope.users = [];
        $scope.loading = false;
        $scope.load = function () {
            var offset = ($scope.currentPage * $scope.itemsPerPage) - $scope.itemsPerPage;
            $scope.loading = true;
            Api.getUsers(offset).then(function (data) {
                $scope.loading = false;
                console.log(data);
                $scope.users = data.users;
                $scope.totalItems = data.total;
            }, function (reason) {
                $scope.loading = false;
                Utils.notification(reason, 'red');
            });
        };

        $scope.load();
    }
]).controller('userAddController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    'UserConst',
    '$location',
    function ($scope, $rootScope, $routeParams, Utils, Api, UserConst, $location) {
        Utils.setTitle('Add User');

        $scope.userGroup = UserConst;
        // $scope.permissionDisabled = $scope.user.group == UserConst.administrator;
        // $scope.user.profile_fields
        $scope.userEdit = {};

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'Users'
            },
            {
                link: "",
                name: 'Add new'
            }
        ]);

        $scope.savingUser = false;
        $scope.errorMessage = false;
        $scope.saveUser = function () {
            $scope.errorMessage = false;
            var user = angular.copy($scope.userEdit);
            $scope.savingUser = true;
            Api.saveUser(user).then(function (data) {
                if (data.user_id) {
                    $location.path('settings/users');
                }
                $scope.savingUser = false;
            }, function (reason) {
                $scope.errorMessage = reason;
                $scope.savingUser = false;
            });
        };

    }
]).controller('oAuthController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    function ($scope, $rootScope, $routeParams, Utils, Api) {
        Utils.setTitle('oAuth applications');

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'OAuth applications'
            }
        ]);

        $scope.settings = {};
        $scope.oauth = {};
        $scope.oauth.isGithub = true;
        $scope.oauth.isBitbucket = true;

        $scope.load = function () {
            $scope.loading = true;
            Api.getOAuthApplications().then(function (data) {
                $scope.settings.github = data.github || {};
                $scope.settings.bitbucket = data.bitbucket || {};
                if (data.bitbucket) {
                    $scope.oauth.isBitbucket = true;
                } else {
                    $scope.oauth.isBitbucket = false;
                }
                if (data.github) {
                    $scope.oauth.isGithub = true;
                } else {
                    $scope.oauth.isGithub = false;
                }

                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };

        $scope.saving = false;
        $scope.save = function () {
            $scope.saving = true;
            var settings = {};
            if ($scope.oauth.isGithub)
                settings.github = $scope.settings.github;
            if ($scope.oauth.isBitbucket)
                settings.bitbucket = $scope.settings.bitbucket;

            Utils.notification('Loading...');
            Api.saveOAuthApplications(settings).then(function () {
                $scope.saving = false;
                Utils.notification('Saved', 'green');
            }, function (reason) {
                Utils.error(reason, 'red', $scope.save);
                $scope.saving = false;
            });
        };
        $scope.load();
    }
]).controller('connectedAccountsController', [
    '$scope',
    '$rootScope',
    '$routeParams',
    'Utils',
    'Api',
    '$window',
    '$location',
    '$ngConfirm',
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $location, $ngConfirm) {
        Utils.setTitle('Connected accounts');

        $rootScope.$broadcast('setBreadcrumb', [
            {
                link: "",
                name: 'Settings'
            },
            {
                link: "",
                name: 'Connected accounts'
            }
        ]);

        $scope.availableApps = {
            github: {
                available: false,
                connected: false,
            },
            bitbucket: {
                available: false,
                connected: false,
            },
        };

        $scope.connected = [];

        if ($routeParams.s) {
            console.log($routeParams);
            if ($routeParams.s == 'failure') {
                var m = $routeParams.e;
                if (m == 0)
                    m = 'Could not connect to the provider';

                Utils.error(m, 'red');
            }
            $location.search('s', null).search('e', null);
        }

        $scope.load = function () {
            $scope.loading = true;

            // get only names of the oauth applications available.
            Api.getConnectedAccounts().then(function (data) {
                $scope.connected = data.connected;
                angular.forEach($scope.connected, function (co) {
                    if (co.provider == 'github')
                        $scope.availableApps.github.connected = true;
                    if (co.provider == 'bitbucket')
                        $scope.availableApps.bitbucket.connected = true;
                });

                $scope.availableApps.github.available = angular.isDefined(data.providers.github);
                $scope.availableApps.bitbucket.available = angular.isDefined(data.providers.bitbucket);

                $scope.loading = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.load);
                $scope.loading = false;
            });
        };

        $scope.load();

        $scope.connect = function (provider) {
            if (!$scope.availableApps[provider].available || $scope.availableApps[provider].connected) {
                return false;
            }

            if (provider == 'github') {
                $window.location.href = GITHUB_CALLBACK;
            } else if (provider == 'bitbucket') {
                $window.location.href = BITBUCKET_CALLBACK;
            } else {
                return false;
            }
        };

        $scope.disconnect = function (id, provider) {
            $ngConfirm({
                title: 'Disconnect from ' + provider + '?',
                content: '<p>' +
                'Are you sure to disconnect from the provider {{provider}}? <br>' +
                '</p>' +
                '<p>The following projects will stop working:</p>' +
                '<div ng-if="affectedProjects.length">' +
                '<div ng-repeat="a in affectedProjects">' +
                '{{a}}' +
                '</div>' +
                '</div>' +
                '<div ng-if="!affectedProjects.length" class="text-muted">' +
                'Found no projects from {{provider}}' +
                '</div>',
                onScopeReady: function (scope) {
                    scope.provider = provider;
                    scope.affectedProjects = [];
                    angular.forEach($scope.projects, function (a) {
                        if (a.provider == provider)
                            scope.affectedProjects.push(a.name);
                    });
                },
                buttons: {
                    disconnect: {
                        btnClass: 'btn-red',
                        action: function (scope, button) {
                            var self = this;
                            button.setText('please wait');
                            button.setDisabled(true);
                            Api.disconnectConnectedAccounts(id).then(function () {
                                Utils.notification('Successfully removed provider ' + provider, 'green');
                                self.close();
                                $scope.load();
                            }, function () {
                                button.setText('disconnect');
                                button.setDisabled(false);
                            });
                            return false;
                        }
                    },
                    close: function () {

                    }
                }
            });
        };
    }
]);
"use strict";

angular.module('App', [
    'ngRoute',
    'AppDirectives',
    'ngAnimate',
    'ServiceUtils',
    'ServiceComponents',
    'ui.bootstrap',
    'ServiceApi',
    'cp.ngConfirm',
    'angularMoment',
    'AppFilters',
    'ngStorage',
    'AppHome',
    'AppSettings',
    'AppProjectNew',
    'AppProjectView',
    'AppProjectSettings',
    'AppProjectServerAdd',
    'AppProjectServerDeploy',
    'AppProjectServerView',
]).config([
    '$routeProvider',
    '$locationProvider',
    '$httpProvider',
    function ($routeProvider, $locationProvider, $httpProvider) {
        $routeProvider.otherwise({
            redirectTo: '/'
        });
        $locationProvider.html5Mode(true);
    }
]).run([
    '$rootScope',
    'Utils',
    '$localStorage',
    '$ngConfirmDefaults',
    'ProjectApi',
    function ($rootScope, Utils, $localStorage, $ngConfirmDefaults, ProjectApi) {
        $ngConfirmDefaults.theme = 'material,gitftp';
        $ngConfirmDefaults.animation = 'scale';
        $ngConfirmDefaults.closeAnimation = 'scale';
        $ngConfirmDefaults.animationSpeed = 300;
        $rootScope.utils = Utils;
        $rootScope.$storage = $localStorage;
        ProjectApi.registerListeners();
    }
]).constant('Const', {
    'clone_state_not_cloned': 1,
    'clone_state_cloning': 2,
    'clone_state_cloned': 3,
    'pull_state_pulled': 1,
    'pull_state_pulling': 2,
    'record_status_success': 4,
    'record_status_failed': 3,
    'record_status_in_progress': 2,
    'record_status_new': 1,
    'record_type_clone': 1,
    'record_type_update': 2,
    'record_type_fresh_upload': 3,
    'record_type_revert': 4,
    'server_type_ftp': 1,
    'server_type_sftp': 2,
    'server_type_local': 3,
}).constant('UserConst', {
    90: 'Member',
    100: 'Administrator',
    'member': 90,
    'administrator': 100,
});
"use strict";

var API_CONNECTION_ERROR = 'Connection could not be established';

angular.bootstrap(document, ['App']);