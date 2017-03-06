"use strict";

angular.module('App.filters', []).filter('searchFilter', function () {
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
}).filter('hilightFilter', function () {
    return function (number, hilight) {
        hilight = hilight || '';
        var h = hilight.toString().split('');
        var n = number.toString().split('');
        angular.forEach(n, function (num, i) {
            if (h.length == 0)
                n[i] = '<span>' + n[i] + '</span>';
            else if (h.indexOf(i.toString()) != -1)
                n[i] = '<span class="y">' + n[i] + '</span>';
            else
                n[i] = '<span class="n">' + n[i] + '</span>';
        });
        return n.join('');
    };
}).filter('capitalizeF', function () {
    return function (input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});