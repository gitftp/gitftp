"use strict";

angular.module('AppFilters', [])
    .filter('sha', function () {
        return function (n) {
            return n.toString().substring(0, 16);
        }
    });