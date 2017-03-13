"use strict";

angular.module('AppFilters', [])
    .filter('sha', function () {
        return function (n) {
            return n.toString().substring(0, 8);
        }
    })
    .filter('searchFilter', function () {
        return function (n, h) {
            h = h || '';
            h = h.toString();
            n = n.toString();
            var l = h.length;
            var i = 0;
            while (i != (l - 1)) {
                var h2 = h.substring(i, l);
                var r2 = new RegExp(h2, 'gi');
                var m = n.match(r2);
                if (m)
                    return n.replace(r2, '<span class="y">' + h2 + '</span>');
                i += 1;
            }

            return n;
        };
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