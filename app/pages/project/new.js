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
    function ($scope, $rootScope, $routeParams, Utils, Api, $window, $location) {
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
                $scope.creating = false;
                // $location.path('view/' + project_id + '/loading');
                $window.location.href = BASE + 'view/' + project_id + '/loading';
            }, function (reason) {
                Utils.error(reason, 'red', $scope.createProject);
                $scope.creating = false;
            })
        };
    }
]);