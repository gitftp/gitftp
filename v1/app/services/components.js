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