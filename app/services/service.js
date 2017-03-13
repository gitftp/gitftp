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
                }, {
                    timeout: defer.promise,
                }).then(function (res) {
                    if (res.data.status) {
                        defer.resolve(res.data.data);
                    } else {
                        defer.reject(res.data.reason);
                    }
                }, function () {
                    defer.reject(API_CONNECTION_ERROR);
                });

                $timeout(function () {
                    defer.resolve();
                }, 200);

                return defer.promise;
            },
            /**
             * Get server but without password.
             * @param server_id
             * @returns {IPromise<T>}
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
             * @returns {IPromise<T>}
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
             * @returns {IPromise<T>}
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
             * @returns {IPromise<T>}
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
             * @returns {IPromise<T>}
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
             * @returns {IPromise<T>}
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
             * create a project
             * @returns {IPromise<T>}
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
             * @returns {IPromise<T>}
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
             * get available branches for the repository by project id
             * @returns {IPromise<T>}
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
                $rootScope.$on('refreshProjects', function (id) {
                    that.refreshProjects();
                });

                var refreshProjectsLoop = function () {
                    $timeout(function () {
                        that.refreshProjects().then(refreshProjectsLoop);
                    }, 5000);
                };

                refreshProjectsLoop();

                this.isListenerActive = true;
            },
            current: false,
            refreshProjects: function () {
                var that = this;
                var defer = $q.defer();
                Api.getProjects().then(function (data) {
                    var object = {};
                    angular.forEach(data, function (a) {
                        object[a.id] = a;
                    });

                    var n = Utils.hash(JSON.stringify(object));
                    if (!that.current || n != that.current) {
                        $rootScope.projects = object;
                        $rootScope.$broadcast('projectsUpdated');
                        that.current = n;
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