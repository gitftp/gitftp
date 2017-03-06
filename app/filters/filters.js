"use strict";

angular.module('AppFilters', [])
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