$(function () {
    window.escapeTag = function(arg){
        var a = arg.replace(/</, '&lt');
        var a = arg.replace(/>/, '&gt');
    }
//    ajaxHelper
    window._ajax = function (arg) {
        return $.ajax(arg)
                .error(function (data) {
                    switch (data.status) {
                        case 0:
                            _problem({
                                content: 'Servers have gone away, please check if you have a active internet connection.',
                                confirm: function () {
                                    location.reload();
                                    return false;
                                },
                                confirmButton: '<i class="fa fa-refresh fa-fw"></i> Reload',
                            });
                            break;
                        case 404:
                            _problem({
                                content: 'Page not found, <br>404',
                                confirm: function () {
                                    history.back();
                                },
                                confrimButton: '<i class="fa fa-arrow-left fa-fw"></i> Back'
                            });
                            break;
                        case 500:
                            _problem({
                                content: 'The code has gone crazy, <br>500',
                                confirm: function () {
                                    history.back();
                                },
                                confrimButton: '<i class="fa fa-arrow-left fa-fw"></i> Back'
                            });
                            break;
                        case 200:
                            _problem({
                                content: 'Something unexpected happened, <br>200',
                                confirm: function () {
                                    history.back();
                                },
                                confrimButton: '<i class="fa fa-arrow-left fa-fw"></i> Back'
                            });
                            break;
                        default:
                            alert('error :' + data.status);
                    }
                }).always(function (data) {
            if (!data.status) {

                if (data.reason == 'GT-405') {
                    _problem({
                        content: 'You\'re not logged in, please login to proceed.',
                        confirm: function () {
                            window.location.reload();
                        },
                        confirmButton: 'Login',
                    });
                }

            }
        });
    }
    window._problem = function (a) {
        var b = {};
        $.extend(b, a, {
            title: 'Problem',
            content: a.text,
            icon: 'fa fa-warning',
            confirmButtonClass: 'btn-warning'
        });
        $.confirm(b);
    }
    window._debug = true;
});