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