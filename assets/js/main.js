$(function () {
    window.escapeTag = function (arg) {
        var a = arg.replace(/</ig, '&lt;');
        a = a.replace(/>/ig, '&gt;');
        return a;
    };

    window.log = function (arg) {
        console.log(arg);
    };

    window.app_reload = function () {
        Backbone.history.loadUrl();
    };

    window.isValidUrl = function (url) {
        //  return /_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS/.test(url);
    };

    window.timestamp = function (stamp) {
        var timestamp = (new Date(parseInt(stamp) * 1000)).getTime();
        return timestamp;
    };

//    ajaxHelper
    window._ajax = function (arg) {
        return $.ajax(arg)
            .error(function (data) {
                switch (data.status) {
                    case 0:
                        _problem({
                            content: 'This is temporary!, <br>Seems like your internet isn\'t working at the moment.',
                            confirm: function () {
                                location.reload();
                                return false;
                            },
                            confirmButton: '<i class="fa fa-refresh"></i>&nbsp; Reload',
                        });
                        break;
                    case 404:
                        _problem({
                            content: 'Page not found, <br><code>Error code: 404</code>',
                            confirm: function () {
                                history.back();
                            },
                            confirmButton: '<i class="fa fa-arrow-left"></i>&nbsp; Back'
                        });
                        break;
                    case 500:
                        _problem({
                            content: 'The code has gone crazy, <br><code>Error code: 500</code>',
                            confirm: function () {
                                history.back();
                            },
                            confirmButton: '<i class="fa fa-arrow-left"></i>&nbsp; Back'
                        });
                        break;
                    case 200:
                        _problem({
                            content: 'Something unexpected happened, <br><code>Error code: 200</code>',
                            confirm: function () {
                                history.back();
                            },
                            confirmButton: '<i class="fa fa-arrow-left"></i>&nbsp; Back'
                        });
                        break;
                    default:
                        alert('error :' + data.status);
                }
            }).always(function (data) {
                if (!data.status) {
                    if (data.reason == '10001') {
                        _problem({
                            title: 'Logged out',
                            content: 'You\'ve been logged out, please login to proceed.',
                            confirm: function () {
                                var currentLocation = window.location.href;
                                window.location.href = home_url + 'login?ref=' + encodeURIComponent(currentLocation);
                            },
                            confirmButton: 'Login',
                            cancelButton: false
                        });
                    }
                }
            });
    }
    window._problem = function (a) {
        var b = {};
        $.extend(b, a, {
            title: a.title || 'Problem',
            content: a.content || 'Please try again later.',
            icon: 'fa fa-warning',
            confirmButtonClass: 'btn-warning'
        });

        if (typeof window._alert == 'undefined') {
            window._alert = $.confirm(b);
        }

        if (window._alert.isClosed()) {
            window._alert = $.confirm(b);
        }

    }
    window.viewClass = function () {
        return 'a' + Math.floor(Math.random() * 999999) + '-wrapper';
    }
    window.getUrlParameter = function (sParam) {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }
    window.getHashUrlParameter = function (sParam) {
        var hash = window.location.hash;
        var sPageURL = hash.substring(hash.indexOf('?') + 1);
        console.log(sPageURL);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }
    window._debug = true;
});