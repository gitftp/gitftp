$(function () {

//    ajaxHelper
    window._ajax = function (arg) {
        return $.ajax(arg)
                .error(function (data) {
                    switch (data.status) {
                        case 0:
                            break;
                    }
                })
    }
    window._problem = function () {
        $.confirm({
            title: 'Problem',
            content: 'Servers have gone away, please check if you have a active internet connection.',
            icon: 'fa fa-rocket',
        })
    }
    window._debug = true;
});