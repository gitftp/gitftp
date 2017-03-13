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
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $q, $ngConfirm, Const) {
        $scope.project_id = $routeParams.id;
        $scope.server_id = $routeParams.server_id;

        $scope.deploy = {};
        $scope.page = 'server-deploy';
        Utils.setTitle('Deploy');

        var server = {};
        angular.forEach($scope.projects[$scope.project_id].servers, function (s) {
            if (s.id == $scope.server_id)
                server = s;
        });
        $scope.server = server;

        $scope.processing = false;
        $scope.startDeploy = function () {
            var deploy = {};
            deploy.type = $scope.deploy.type;
            if (deploy.type == Const.record_type_re_upload) {
                deploy.target_revision = $scope.latestCommit.sha;
            }
            $scope.processing = true;
            Api.applyDeploy($scope.project_id, $scope.server_id, deploy).then(function (res) {
                $scope.processing = false;
            }, function (reason) {
                Utils.error(reason, 'red', $scope.startDeploy);
                $scope.processing = false;
            })
        };

        $scope.gettingLatest = false;
        $scope.latestCommit = {};
        $scope.last30Commits = [];
        $scope.getLatestRevision = function () {
            $scope.gettingLatest = true;
            Api.getRevisions($scope.project_id, $scope.server.branch).then(function (revisions) {
                $scope.last30Commits = revisions;
                $scope.latestCommit = $scope.last30Commits[0];
                $scope.gettingLatest = false;
            }, function (reason) {
                $scope.gettingLatest = false;
                Utils.error(reason, 'red', $scope.showRevisions);
            });
        };
        $scope.getLatestRevision();
        if ($scope.server.revision) {
            $scope.deploy.type = Const.record_type_update;
        } else {
            $scope.deploy.type = Const.record_type_re_upload;
        }


        $scope.showRevisions = function () {
            $ngConfirm({
                title: 'Recent commits',
                content: '' +
                '<div class="loader p-25 p-t-70" ng-if="loading" style="width: 60px"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/></svg></div>' +
                '' +
                '<div class="list-group">' +
                '<a class="list-group-item p-10" ng-click="select(r.sha)" ng-repeat="r in revisions">' +
                '<strong>{{r.message}}</strong> <code class="pull-right"><small class="">{{r.sha | sha}}</small></code>' +
                '<br><small class="text-muted">{{r.author}} committed on {{r.time | amFromUnix | amDateFormat : "MMM DD, YYYY"}}</small>' +
                '</a>' +
                '</div>',
                animation: 'top',
                closeAnimation: 'top',
                onOpen: function (scope) {
                    var that = this;
                    scope.loading = true;
                    scope.revisions = [];

                    Api.getRevisions($scope.project_id, $scope.server.branch).then(function (revisions) {
                        console.log(revisions);
                        scope.revisions = revisions;
                        scope.loading = false;
                    }, function (reason) {
                        scope.loading = false;
                        Utils.error(reason, 'red', $scope.showRevisions);
                    });

                    scope.select = function (sha) {
                        $scope.server.revision = sha;
                        that.close();
                    }
                }
            });
        }
    }
]);