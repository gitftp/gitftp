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
        if ($scope.server.revision) {
            $scope.deploy.type = Const.record_type_update;
        } else {
            $scope.deploy.type = Const.record_type_re_upload;
        }

        $scope.gettingLatest = false;
        $scope.latestCommit = {};
        $scope.last30Commits = [];
        $scope.getLatestRevision = function () {
            if ($scope.last30Commits.length)
                return false;

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


        $scope.fetchingComparision = false;
        $scope.targetCommit = "HEAD";
        $scope.fetchComparision = function () {
            $scope.fetchingComparision = true;
            Api.compareCommits($scope.project_id, $scope.server_id, $scope.server.revision, $scope.targetCommit)
                .then(function (comparison) {
                    $scope.fetchingComparision = false;
                    console.log(comparison);
                }, function (reason) {
                    $scope.fetchingComparision = false;
                    Utils.error(reason, 'red', $scope.fetchComparision);
                })
        };


        $scope.$watch('deploy.type', function () {
            console.log($scope.deploy.type);
            if ($scope.deploy.type == Const.record_type_update) {
                $scope.fetchComparision();
            } else {
                $scope.getLatestRevision();
            }
        });


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
    }
]);