"use strict";

angular.module('App', [
    'ngRoute',
    'AppDirectives',
    'ngAnimate',
    'ServiceUtils',
    'ServiceApi',
    'cp.ngConfirm',
    'angularMoment',
    'AppFilters',
    'ngStorage',
    'AppHome',
    'AppSettings',
    'AppProjectNew',
    'AppProjectView',
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
    function ($rootScope, Utils, $localStorage, $ngConfirmDefaults) {
        $ngConfirmDefaults.theme = 'material,gitftp';
        $ngConfirmDefaults.animation = 'scale';
        $ngConfirmDefaults.closeAnimation = 'scale';
        $rootScope.utils = Utils;
        $rootScope.$storage = $localStorage;
    }
]).constant('Const', {
    'clone_state_not_cloned': 1,
    'clone_state_cloning': 2,
    'clone_state_cloned': 3,
});