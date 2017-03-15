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