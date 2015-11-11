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
                            title: false,
                            content: 'This is temporary, it seems like your internet isn\'t working at the moment.',
                            confirm: function () {
                                location.reload();
                                return false;
                            },
                            confirmButton: '<i class="fa fa-refresh"></i>&nbsp; Reload'
                        });
                        break;
                    case 404:
                    case 200:
                    case 500:
                    default:
                        _problem({
                            title: false,
                            content: '<div class="space10"></div>' +
                            'Something is not right, Please reload the browser and try again. <br>Error code: <code>' + data.status + '</code>',
                            icon: 'fa fa-exclamation-circle',
                            confirm: function () {
                                history.back();
                            },
                            confirmButton: '<i class="fa fa-arrow-left"></i>&nbsp; Back',
                            cancelButton: 'close'
                        });
                        break;
                }
            }).always(function (data) {
                console.log('Received data: ', data);
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
            title: typeof a.title == 'undefined' ? 'Problem' : a.title,
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
    };
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
    };
    window._debug = true;
    window.defaultTitle = 'Gitftp Console';
    window.setTitle = function (title) {
        if (title)
            document.title = title + ' - ' + window.defaultTitle;
        else
            document.title = window.defaultTitle;
    }

    $.easing.jswing = $.easing.swing, $.extend($.easing, {
        easeOutQuart: function (f, d, c, b, g) {
            return -b * ((d = d / g - 1) * d * d * d - 1) + c
        }, easeOutExpo: function (f, d, c, b, g) {
            return d == g ? c + b : b * (-Math.pow(2, -10 * d / g) + 1) + c
        }, easeOutElastic: function (h, f, d, c, k) {
            var b = 1.70158, j = 0, g = c;
            if (0 == f) {
                return d
            }
            if (1 == (f /= k)) {
                return d + c
            }
            if (j || (j = 0.3 * k), g < Math.abs(c)) {
                g = c;
                var b = j / 4
            } else {
                var b = j / (2 * Math.PI) * Math.asin(c / g)
            }
            return g * Math.pow(2, -10 * f) * Math.sin((f * k - b) * 2 * Math.PI / j) + c + d
        }
    });

    (function ($) {
        $.fn.serializeObject = function () {
            "use strict";
            var result = {};
            var extend = function (i, element) {
                var node = result[element.name];
                if ('undefined' !== typeof node && node !== null) {
                    if ($.isArray(node)) {
                        node.push(element.value);
                    } else {
                        result[element.name] = [node, element.value];
                    }
                } else {
                    result[element.name] = element.value;
                }
            };
            $.each(this.serializeArray(), extend);
            return result;
        };
    })(jQuery);

});